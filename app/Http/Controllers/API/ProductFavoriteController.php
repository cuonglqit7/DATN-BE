<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductFavorite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Favorites",
 *     description="API quản lý danh sách sản phẩm yêu thích"
 * )
 */
class ProductFavoriteController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/addToFavorites",
     *     summary="Thêm sản phẩm vào danh sách yêu thích",
     *     tags={"Favorites"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"product_id"},
     *             @OA\Property(property="product_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Thêm sản phẩm thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Thêm sản phẩm thành công"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lỗi server"
     *     )
     * )
     */
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
                'message' => 'Thêm sản phẩm thành công',
                'data' => $favorite
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/removeFromFavorites",
     *     summary="Xóa sản phẩm khỏi danh sách yêu thích",
     *     tags={"Favorites"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"product_id"},
     *             @OA\Property(property="product_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Đã bỏ thích thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Đã bỏ thích thành công")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sản phẩm chưa được thích"
     *     )
     * )
     */
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
                return response()->json(['message' => 'Đã bỏ thích thành công'], Response::HTTP_OK);
            }

            return response()->json(['message' => 'Sản phẩm này chưa được thích'], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/favorites",
     *     summary="Lấy danh sách sản phẩm yêu thích",
     *     tags={"Favorites"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách sản phẩm yêu thích",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách sản phẩm yêu thích thành công"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function getUserFavorites()
    {
        try {
            $userId = auth()->id();

            $favorites = ProductFavorite::where('user_id', $userId)
                ->with(['product' => function ($query) {
                    $query->select('id', 'slug', 'product_name', 'price', 'promotion_price');
                }])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'message' => 'Lấy danh sách sản phẩm yêu thích thành công',
                'data' => $favorites
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/isFavorite",
     *     summary="Kiểm tra sản phẩm có trong danh sách yêu thích không",
     *     tags={"Favorites"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"product_id"},
     *             @OA\Property(property="product_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sản phẩm đã được thích",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sản phẩm đã được thích"),
     *             @OA\Property(property="favorite", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sản phẩm chưa được thích"
     *     )
     * )
     */
    public function isFavorite(Request $request, string $id)
    {
        try {
            $user = auth()->user();

            $isFavorite = ProductFavorite::where('user_id', $user->id)
                ->where('product_id', $id)
                ->exists();

            return response()->json([
                'message' => $isFavorite ? 'Sản phẩm đã được thích' : 'Sản phẩm chưa được thích',
                'isFavorite' => $isFavorite
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
