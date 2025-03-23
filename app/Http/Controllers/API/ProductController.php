<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\SendResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

            $query = Product::with('avatar', 'category', 'attributes');

            // Phân trang
            $products = $query->orderBy('created_at', 'DESC')->paginate($limit);

            // Thêm full URL cho avatar
            $products->getCollection()->transform(function ($product) {
                $product->avatar_url = $product->avatar ? asset(Storage::url($product->avatar->image_url)) : null;
                return $product;
            });

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
    public function show($slug)
    {
        $product = Product::with('category', 'images', 'attributes', 'productReviews')
            ->where('slug', $slug)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Chỉnh sửa đường dẫn của tất cả hình ảnh trước khi trả về
        $product->images = $product->images->map(function ($image) {
            $image->url = url('storage/' . $image->image_url); // hoặc Storage::url($image->path)
            return $image;
        });

        return response()->json($product, 200);
    }

    public function getById($id)
    {
        $product = Product::with('avatar')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Thêm full URL vào avatar
        $product->avatar_url = $product->avatar ? asset('storage/' . $product->avatar->image_url) : null;

        return response()->json($product, 200);
    }




    public function getBestSellingProducts()
    {
        try {
            $oneWeekAgo = now()->subWeek(); // Lấy thời điểm một tuần trước

            $products = Product::with('avatar', 'category', 'attributes')
                ->where('best_selling', true)
                ->whereBetween('updated_at', [$oneWeekAgo, now()]) // Lọc theo thời gian cập nhật trong tuần qua
                ->orderBy('quantity_sold', 'DESC')
                ->limit(8)->get();

            // Gắn full URL cho avatar
            $products->transform(function ($product) {
                $product->avatar_url = $product->avatar ? asset(Storage::url($product->avatar->image_url)) : null;
                return $product;
            });

            return $this->successResponse($products, "Lấy danh sách sản phẩm bán chạy trong tuần qua thành công");
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy danh sách thất bại", $th->getMessage());
        }
    }
}
