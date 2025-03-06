<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/payments",
     *     summary="Create a payment",
     *     tags={"Payments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"order_id", "payment_method", "transaction_id", "amount"},
     *             @OA\Property(property="order_id", type="integer", example=1),
     *             @OA\Property(property="payment_method", type="string", enum={"Bank_transfer", "Momo"}),
     *             @OA\Property(property="transaction_id", type="string", example="TXN123456"),
     *             @OA\Property(property="amount", type="number", format="float", example=100.50)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Payment created successfully"),
     *     @OA\Response(response=422, description="Validation errors")
     * )
     */
    public function createPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|exists:orders,id',
                'payment_method' => 'required|in:Bank_transfer,Momo',
                'transaction_id' => 'required|string|unique:payments,transaction_id',
                'amount' => 'required|numeric|min:0.01',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $order = Order::findOrFail($request->order_id);

            // Kiểm tra số tiền thanh toán có khớp với đơn hàng không
            if ($request->amount != $order->total_price) {
                return response()->json([
                    'error' => 'Số tiền thanh toán không khớp với tổng giá trị đơn hàng.'
                ], Response::HTTP_BAD_REQUEST);
            }

            // Tạo bản ghi thanh toán
            $payment = Payment::create([
                'order_id' => $request->order_id,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'amount' => $request->amount,
                'payment_status' => 'Pending',
            ]);

            return response()->json(['message' => 'Thanh toán đã được tạo.', 'data' => $payment], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/payments/{id}",
     *     summary="Update payment status",
     *     tags={"Payments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"payment_status"},
     *             @OA\Property(property="payment_status", type="string", enum={"Pending", "Completed", "Failed", "Refunded"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Payment status updated successfully"),
     *     @OA\Response(response=422, description="Validation errors"),
     *     @OA\Response(response=404, description="Payment not found")
     * )
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'payment_status' => 'required|in:Pending,Completed,Failed,Refunded',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'errors' => $validator->errors()
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $payment = Payment::findOrFail($id);
            $payment->update(['payment_status' => $request->payment_status]);

            return response()->json(
                [
                    'message' => 'Trạng thái thanh toán đã được cập nhật.',
                    'data' => $payment
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
