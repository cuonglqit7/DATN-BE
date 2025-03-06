<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderDiscount;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function createOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'nullable|exists:users,id',
                'recipient_name' => 'required|string|max:50',
                'recipient_phone' => 'required|string|max:10',
                'shipping_address' => 'required|string|max:500',
                'total_price' => 'required|numeric|min:0',
                'discounts' => 'nullable|array',
                'discounts.*.discount_id' => 'exists:discounts,id',
                'payment_method' => 'required|in:Bank_transfer,Momo,cod',
                'user_note' => 'nullable|string|max:200',
                'items' => 'required|array',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $errorQuantity = [];
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->quantity_in_stock < $item['quantity']) {
                    $errorQuantity[$item['product_id']] = "Sản phẩm $product->product_name không đủ hàng.";
                }
            }

            if (!empty($errorQuantity)) {
                return response()->json([
                    'errors' => $errorQuantity,
                ], Response::HTTP_BAD_REQUEST);
            }

            $order = Order::create([
                'user_id' => $request->user_id,
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'shipping_address' => $request->shipping_address,
                'total_price' => $request->total_price,
                'payment_method' => $request->payment_method,
                'payment_status' => 'Pending',
                'status' => 'Pending',
                'user_note' => $request->user_note,
                'admin_note' => null,
                'ip_address' => $request->getClientIp(),
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $unit_price = $product->promotion_price;
                $total_price = $unit_price * $item['quantity'];

                // Kiểm tra số lượng tồn kho trước khi trừ
                if ($product->quantity_in_stock < $item['quantity']) {
                    return response()->json([
                        'error' => "Sản phẩm $product->product_name không đủ hàng trong kho.",
                    ], Response::HTTP_BAD_REQUEST);
                }

                $product->quantity_in_stock -= $item['quantity'];
                $product->quantity_sold += $item['quantity'];
                $product->save();

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $unit_price,
                    'total_price' => $total_price,
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

            return response()->json(['message' => 'Đã tạo đơn hàng thành công', 'data' => $order], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function cancelOrder($orderId)
    {
        try {
            $order = Order::find($orderId);

            if (!$order) {
                return response()->json(['message' => 'Không tìm thấy đơn hàng'], 404);
            }

            if ($order->status !== 'Pending') {
                return response()->json(['message' => 'Chỉ đơn hàng có trạng thái "Pending" mới được hủy'], 400);
            }

            $order->update(['status' => 'Cancelled']);

            return response()->json(['message' => 'Hủy đơn hàng thành công']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getOrderByIp(Request $request)
    {
        try {
            $orders = Order::with('orderItems')
                ->where('ip_address', $request->getClientIp())
                ->get();

            if (!$orders) {
                return response()->json([
                    'error' => 'Bạn chưa có đơn hàng nào',
                ]);
            }

            return response()->json(['orders' => $orders]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
