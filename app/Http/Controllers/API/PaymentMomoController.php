<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderDiscount;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Faker\Provider\bg_BG\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentMomoController extends Controller
{
    public function createPayment(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'errors' => [
                    'user' => 'Vui lòng đăng nhập để đặt hàng'
                ],
            ], Response::HTTP_UNAUTHORIZED);
        }

        $validator = Validator::make($request->all(), [
            'recipient_name' => 'required|string|max:50',
            'recipient_phone' => 'required|string|size:10',
            'shipping_address' => 'required|string|max:500',
            'amount' => 'required|numeric|min:0',
            'discounts' => 'nullable|array',
            'discounts.*.discount_id' => 'exists:discounts,id',
            'payment_method' => 'required|in:Bank_transfer,Momo,cod',
            'user_note' => 'nullable|string|max:200',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'code' => 'required|string|size:11',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $errorQuantity = [];
        $items = [];
        foreach ($request->items as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->quantity_in_stock < $item['quantity']) {
                $errorQuantity[$item['id']] = "Sản phẩm {$product->product_name} không đủ hàng.";
            } else {
                $price = $product->promotion_price ?? $product->price;
                $items[] = [
                    'id' => (string) $item['id'],
                    'name' => $product->product_name,
                    'price' => (int) $price,
                    'quantity' => (int) $item['quantity'],
                ];
            }
        }

        if (!empty($errorQuantity)) {
            return response()->json(['errors' => $errorQuantity], Response::HTTP_BAD_REQUEST);
        }

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = "MOMO";
        $accessKey = "F8BBA842ECF85";
        $secretKey = "K951B6PE1waDMi640xX08PD3vg6EkVlz";

        $orderId = $request->code;
        $amount = $request->amount;
        $orderInfo = "Thanh toán đơn hàng #" . $orderId;
        $redirectUrl = "http://localhost:3000/tai-khoan/don-hang";
        $ipnUrl = "https://a1cc-2402-800-637d-aab0-3011-8eff-f382-de53.ngrok-free.app/api/v1/momo/payment/callback";
        $requestId = $request->code;
        $requestType = "payWithMethod";
        $extraData = '';

        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $userInfo = [
            "name" => $request->recipient_name,
            "phoneNumber" => $request->recipient_phone,
            "email" => $request->email ?? $user->email,
        ];

        $data = [
            "partnerCode" => $partnerCode,
            "requestId" => $requestId,
            "amount" => (int) $amount,
            "orderId" => $orderId,
            "orderInfo" => $orderInfo,
            "redirectUrl" => $redirectUrl,
            "ipnUrl" => $ipnUrl,
            "requestType" => $requestType,
            "extraData" => $extraData,
            "userInfo" => $userInfo,
            "items" => $items,
            "lang" => "vi",
            "signature" => $signature,
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($endpoint, $data);
        $result = $response->json();

        if ($result['resultCode'] == 0) {
            $order = Order::create([
                'user_id' => $user->id,
                'code' => $request->code,
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'shipping_address' => $request->shipping_address,
                'total_price' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'Pending',
                'status' => 'Pending',
                'user_note' => $request->user_note,
                'admin_note' => null,
            ]);

            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'Momo',
                'amount' => $request->amount,
                'payment_status' => 'Pending',
                'url_payment' => $result['payUrl']
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);
                $unit_price = $product->promotion_price ?? $product->price;

                if ($product->quantity_in_stock < $item['quantity']) {
                    return response()->json([
                        'errors' => ["Sản phẩm {$product->product_name} không đủ hàng trong kho."],
                    ], Response::HTTP_BAD_REQUEST);
                }

                $product->quantity_in_stock -= $item['quantity'];
                $product->quantity_sold += $item['quantity'];
                $product->save();

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $unit_price,
                ]);
            }

            if (!empty($request->discounts)) {
                foreach ($request->discounts as $discountData) {
                    $discount = Discount::find($discountData['discount_id']);
                    if ($discount) {
                        OrderDiscount::create([
                            'order_id' => $order->id,
                            'discount_id' => $discount->id,
                        ]);
                    }
                }
            }

            return response()->json($result);
        } else {
            return response()->json(['error' => $result['message']], Response::HTTP_BAD_REQUEST);
        }
    }

    public function callback(Request $request)
    {
        $data = $request->all();
        Log::info('MoMo Notify Response:', ['data' => $data]);

        $order = Order::where('code', $data['orderId'])->first();
        $payment = Payment::where('order_id', $order->id)->first();

        if ($data['resultCode'] == 0) {
            $order->update(['payment_status' => 'Completed']);

            $payment->update([
                'transaction_id' => $request->transId,
                'payment_status' => 'Completed'
            ]);
        } else {
            $order->update(['payment_status' => 'Failed']);

            $payment->update([
                'transaction_id' => $request->transId,
                'payment_status' => 'Failed'
            ]);
        }

        return response()->json(['message' => 'Notification processed'], Response::HTTP_OK);
    }

    public function transactionStatus(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/query";
        $partnerCode = "MOMO";
        $accessKey = "F8BBA842ECF85";
        $secretKey = "K951B6PE1waDMi640xX08PD3vg6EkVlz";

        $orderId = $request->orderId;
        $requestId = $request->orderId;

        $rawHash = "accessKey=$accessKey&orderId=$orderId&partnerCode=$partnerCode&requestId=$requestId";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'requestId' => $requestId,
            'orderId' => $orderId,
            'signature' => $signature,
            'lang' => 'vi'

        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($endpoint, $data);
        $result = $response->json();

        return response()->json($result);
    }
}
