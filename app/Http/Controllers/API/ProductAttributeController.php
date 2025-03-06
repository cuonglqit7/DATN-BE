<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Traits\SendResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Product Attributes",
 *     description="API quản lý thuộc tính sản phẩm"
 * )
 */
class ProductAttributeController extends Controller
{
    use SendResponse;

    /**
     * @OA\Get(
     *     path="/api/product-attributes",
     *     summary="Lấy tất cả thuộc tính nhóm theo tên",
     *     tags={"Product Attributes"},
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách thuộc tính nhóm theo tên",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Lấy tất cả thuộc tính"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\AdditionalProperties(
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="value", type="string", example="Red"),
     *                         @OA\Property(property="count", type="integer", example=10)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không có thuộc tính nào được tìm thấy",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Không có thuộc tính")
     *         )
     *     )
     * )
     */
    public function getAllGroupedAttributes()
    {
        try {
            $attributes = ProductAttribute::select('attribute_name', 'attribute_value')
                ->selectRaw('COUNT(product_id) as product_count')
                ->groupBy('attribute_name', 'attribute_value')
                ->orderBy('attribute_name', 'ASC')
                ->get()
                ->groupBy('attribute_name')
                ->map(function ($group) {
                    return $group->map(function ($item) {
                        return [
                            'value' => $item->attribute_value,
                            'count' => $item->product_count
                        ];
                    })->values();
                });

            if ($attributes->isEmpty()) {
                return response()->json([
                    'message' => 'Không có thuộc tính',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'message' => 'Lấy tất cả thuộc tính',
                'data' => $attributes,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Lấy thuộc tính sản phẩm thất bại',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/product-attributes/{product_id}",
     *     summary="Lấy danh sách thuộc tính của một sản phẩm",
     *     tags={"Product Attributes"},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="path",
     *         required=true,
     *         description="ID của sản phẩm",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách thuộc tính của sản phẩm",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Lấy thuộc tính sản phẩm thành công"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="attribute_name", type="string", example="Color"),
     *                     @OA\Property(property="attribute_value", type="string", example="Blue"),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-01T12:34:56Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-01T12:34:56Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không tìm thấy thuộc tính của sản phẩm",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Không có thuộc tính for this product")
     *         )
     *     )
     * )
     */
    public function getAttributesByProduct($product_id)
    {
        try {
            $attributes = ProductAttribute::where('product_id', $product_id)->get();

            if ($attributes->isEmpty()) {
                return response()->json([
                    'message' => 'Không có thuộc tính for this product',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'message' => 'Lấy thuộc tính sản phẩm thành công',
                'data' => $attributes,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Lấy thuộc tính sản phẩm thất bại',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
