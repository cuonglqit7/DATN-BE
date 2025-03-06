<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DiscountController extends Controller
{


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
