<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\SendResponse;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API sản phẩm"
 * )
 */
class ProductController extends Controller
{
    use SendResponse;

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Lấy danh sách sản phẩm",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Số lượng sản phẩm trên mỗi trang (mặc định: 8)",
     *         @OA\Schema(type="integer", example=8)
     *     ),
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="ID danh mục để lọc sản phẩm",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="min_price",
     *         in="query",
     *         description="Giá tối thiểu để lọc sản phẩm",
     *         @OA\Schema(type="number", format="float", example=100000)
     *     ),
     *     @OA\Parameter(
     *         name="max_price",
     *         in="query",
     *         description="Giá tối đa để lọc sản phẩm",
     *         @OA\Schema(type="number", format="float", example=500000)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách sản phẩm",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Lấy danh sách sản phẩm thành công"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="product_name", type="string", example="Laptop Gaming Asus"),
     *                     @OA\Property(property="slug", type="string", example="laptop-gaming-asus"),
     *                     @OA\Property(property="description", type="string", example="Laptop gaming mạnh mẽ với RTX 4060."),
     *                     @OA\Property(property="price", type="number", format="float", example=25000000),
     *                     @OA\Property(property="promotion_price", type="number", format="float", example=22000000),
     *                     @OA\Property(property="quantity_in_stock", type="integer", example=10),
     *                     @OA\Property(property="quantity_sold", type="integer", example=2),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="category_id", type="integer", example=1),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:34:56Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:34:56Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lỗi server khi lấy danh sách sản phẩm",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Lấy danh sách sản phẩm thất bại"),
     *             @OA\Property(property="error", type="string", example="Lỗi chi tiết")
     *         )
     *     )
     * )
     */
    public function getAll(Request $request)
    {
        try {
            $limit = is_numeric($request->limit) ? (int) $request->limit : 8;

            $query = Product::with('category', 'attributes');

            // Lọc theo danh mục
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // Lọc theo giá
            if ($request->has('min_price')) {
                $query->where('promotion_price', '>=', $request->min_price);
            }
            if ($request->has('max_price')) {
                $query->where('promotion_price', '<=', $request->max_price);
            }

            // Phân trang
            $products = $query->orderBy('created_at', 'DESC')->paginate($limit);

            return $this->successResponse($products, "Lấy danh sách sản phẩm thành công");
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy danh sách sản phẩm thất bại", $th->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Lấy chi tiết sản phẩm theo ID",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID của sản phẩm",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Chi tiết sản phẩm",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Lấy chi tiết sản phẩm thành công"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="product_name", type="string", example="Laptop Gaming Asus"),
     *                 @OA\Property(property="slug", type="string", example="laptop-gaming-asus"),
     *                 @OA\Property(property="description", type="string", example="Laptop gaming mạnh mẽ với RTX 4060."),
     *                 @OA\Property(property="price", type="number", format="float", example=25000000),
     *                 @OA\Property(property="promotion_price", type="number", format="float", example=22000000),
     *                 @OA\Property(property="quantity_in_stock", type="integer", example=10),
     *                 @OA\Property(property="quantity_sold", type="integer", example=2),
     *                 @OA\Property(property="status", type="boolean", example=true),
     *                 @OA\Property(property="category_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:34:56Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:34:56Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không tìm thấy sản phẩm",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Không tìm thấy sản phẩm"),
     *             @OA\Property(property="error", type="string", example="Not Found")
     *         )
     *     )
     * )
     */
    public function getById($id)
    {
        try {
            $product = Product::with('category')->find($id);

            if (!$product) {
                return $this->errorResponse("Không tìm thấy sản phẩm", "Not Found");
            }

            return $this->successResponse($product, "Lấy chi tiết sản phẩm thành công");
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy chi tiết sản phẩm thất bại", $th->getMessage());
        }
    }
}
