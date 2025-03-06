<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DiscountController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/discounts/check",
     *     summary="Kiểm tra mã giảm giá",
     *     tags={"Discounts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"code"},
     *             @OA\Property(property="code", type="string", example="SUMMER2024")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mã giảm giá hợp lệ",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Mã giảm giá hợp lệ"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="code", type="string", example="SUMMER2024"),
     *                 @OA\Property(property="discount_type", type="string", example="Percentage"),
     *                 @OA\Property(property="discount_value", type="number", format="float", example=20.00),
     *                 @OA\Property(property="start_date", type="string", format="date", example="2024-03-01"),
     *                 @OA\Property(property="end_date", type="string", format="date", example="2024-03-31"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:30:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mã giảm giá không hợp lệ hoặc đã hết hạn",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Mã giảm giá không hợp lệ hoặc đã hết hạn")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lỗi server",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Lỗi không xác định")
     *         )
     *     )
     * )
     */

    public function check(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string|max:50'
            ]);

            $discount = Discount::where('code', $request->code)
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->first();

            if (!$discount) {
                return response()->json(['message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn'], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'message' => 'Mã giảm giá hợp lệ',
                'data' => $discount
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/discounts",
     *     summary="Lấy danh sách mã giảm giá hợp lệ",
     *     tags={"Discounts"},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách mã giảm giá thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách mã giảm giá thành công"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="code", type="string", example="SUMMER2024"),
     *                     @OA\Property(property="discount_type", type="string", example="Percentage"),
     *                     @OA\Property(property="discount_value", type="number", format="float", example=20.00),
     *                     @OA\Property(property="start_date", type="string", format="date", example="2024-03-01"),
     *                     @OA\Property(property="end_date", type="string", format="date", example="2024-03-31"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:30:00Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lỗi server",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Lỗi không xác định")
     *         )
     *     )
     * )
     */

    public function getAllDiscounts()
    {
        try {
            $validDiscounts = Discount::whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'message' => 'Lấy danh sách mã giảm giá thành công',
                'data' => $validDiscounts
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/discounts/{id}",
     *     summary="Lấy chi tiết mã giảm giá",
     *     tags={"Discounts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID của mã giảm giá",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lấy chi tiết mã giảm giá thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy chi tiết mã giảm giá thành công"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="code", type="string", example="SUMMER2024"),
     *                 @OA\Property(property="discount_type", type="string", example="Percentage"),
     *                 @OA\Property(property="discount_value", type="number", format="float", example=20.00),
     *                 @OA\Property(property="start_date", type="string", format="date", example="2024-03-01"),
     *                 @OA\Property(property="end_date", type="string", format="date", example="2024-03-31"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:30:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lỗi server",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Lỗi không xác định")
     *         )
     *     )
     * )
     */

    public function getDiscountById(string $id)
    {
        try {
            $dicount = Discount::find($id);

            return response()->json([
                'message' => 'Lấy chi tiết mã giảm thành công',
                'data' => $dicount
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
