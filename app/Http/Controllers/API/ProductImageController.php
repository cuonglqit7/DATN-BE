<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Traits\SendResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Product Images",
 *     description="API hình ảnh sản phẩm"
 * )
 */
class ProductImageController extends Controller
{
    use SendResponse;
    /**
     * @OA\Get(
     *     path="/api/products/{product_id}/avatar",
     *     summary="Lấy ảnh đại diện của sản phẩm",
     *     tags={"Product Images"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="path",
     *         required=true,
     *         description="ID của sản phẩm",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trả về URL ảnh đại diện của sản phẩm",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy hình avatar thành công"),
     *             @OA\Property(property="data", type="string", example="https://yourdomain.com/storage/avatar.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không tìm thấy ảnh đại diện",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Hình avatar không có")
     *         )
     *     )
     * )
     */
    public function getAvatar(string $product_id)
    {
        try {
            $avatar = ProductImage::where('product_id', $product_id)
                ->where('is_primary', true)->first();

            if (!$avatar) {
                return response()->json([
                    'message' => 'Hình avatar không có',
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'message' => 'Lấy hình avatar thành công',
                'data' => asset('storage/' . $avatar->image_url),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse("Fetch avatar fail", $th->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/{product_id}/images",
     *     summary="Lấy tất cả hình ảnh của sản phẩm",
     *     tags={"Product Images"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="path",
     *         required=true,
     *         description="ID của sản phẩm",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách hình ảnh của sản phẩm",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy hình sản phẩm thành công"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="image_url", type="string", example="https://yourdomain.com/storage/image1.jpg"),
     *                     @OA\Property(property="alt_text", type="string", example="Hình ảnh sản phẩm")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không tìm thấy hình ảnh",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy hình sản phẩm thất bại")
     *         )
     *     )
     * )
     */
    public function getAll(string $product_id)
    {
        try {
            $images = ProductImage::where('product_id', $product_id)->orderBy('is_primary', 'DESC')->get();

            if (!$images) {
                return response()->json([
                    'message' => 'Lấy hình sản phẩm thất bại',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'message' => 'Lấy hình sản phẩm thành công',
                'data' => $images->map(function ($image) {
                    return [
                        'image_url' => asset('storage/' . $image->image_url),
                        'alt_text' => $image->alt_text,
                    ];
                })
            ]);
        } catch (\Throwable $th) {
            return $this->errorResponse("Fetch images fail", $th->getMessage());
        }
    }
}
