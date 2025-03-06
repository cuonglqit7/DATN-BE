<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFavorite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function Laravel\Prompts\error;

class ProductFavoriteController extends Controller
{
    public function addToFavorites(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);

            $user = auth()->user();

            $favorite = ProductFavorite::firstOrCreate([
                'product_id' => $request->product_id,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => 'Thêm sản phẩm thánh công',
                'data' => $favorite
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function removeFromFavorites(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);

            $user = auth()->user();

            $deleted = ProductFavorite::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->delete();

            if ($deleted) {
                return response()->json(['message' => 'Đã bỏ thích thành công']);
            }

            return response()->json(['message' => 'Sản phẩm này chưa được thích'], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getUserFavorites()
    {
        $userId = auth()->id();

        $favorites = ProductFavorite::with('product')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Lấy danh sách sản phẩm yêu thích của user thành công',
            'data' => $favorites
        ], Response::HTTP_OK);
    }

    public function isFavorite(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = auth()->user;

        $isFavorite = ProductFavorite::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->exists();

        return response()->json([
            'message' => $isFavorite ? 'Sản phẩm đã được thích' : 'Sản phẩm chưa được thích',
            'favorite' => $isFavorite
        ]);
    }
}
