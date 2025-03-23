<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\SendResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    use SendResponse;
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Lấy danh sách danh mục sản phẩm",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách danh mục sản phẩm thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách danh mục sản phẩm thành công"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="category_name", type="string", example="Điện thoại"),
     *                     @OA\Property(property="slug", type="string", example="dien-thoai"),
     *                     @OA\Property(property="position", type="integer", example=1),
     *                     @OA\Property(property="description", type="string", nullable=true, example="Danh mục điện thoại cao cấp"),
     *                     @OA\Property(property="parent_id", type="integer", nullable=true, example=null),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:30:00Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lấy danh sách danh mục sản phẩm thất bại",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách danh mục sản phẩm thất bại"),
     *             @OA\Property(property="errors", type="string", example="Lỗi server")
     *         )
     *     )
     * )
     */

    public function getAll(Request $request)
    {
        try {
            $categories = Category::orderBy('position', 'ASC')->get();

            // Dùng map() để biến đổi danh sách
            $categories = $categories->map(function ($category) {
                $category->image_url = $category->image_url
                    ? asset(Storage::url($category->image_url))
                    : null;
                return $category;
            });

            return response()->json([
                'message' => 'Lấy danh sách danh mục sản phẩm thành công',
                'data' => $categories
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy danh sách danh mục sản phẩm thất bại", $th->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/categories/parent",
     *     summary="Lấy danh sách danh mục cấp cha",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách danh mục cấp cha thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách danh mục cấp cha thành công"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="category_name", type="string", example="Điện thoại"),
     *                     @OA\Property(property="slug", type="string", example="dien-thoai"),
     *                     @OA\Property(property="position", type="integer", example=1),
     *                     @OA\Property(property="description", type="string", nullable=true, example="Danh mục điện thoại cao cấp"),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:30:00Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function getParentCategories()
    {
        try {
            $categories = Category::whereNull('parent_id')
                ->orderBy('position', 'ASC')
                ->get();

            return response()->json([
                'message' => 'Lấy danh sách danh mục cấp cha thành công',
                'data' => $categories
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy danh sách danh mục cấp cha thất bại", $th->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{parent_id}/children",
     *     summary="Lấy danh sách danh mục con theo ID danh mục cha",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="parent_id",
     *         in="path",
     *         required=true,
     *         description="ID của danh mục cha",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách danh mục con thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách danh mục con thành công"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="category_name", type="string", example="iPhone"),
     *                     @OA\Property(property="slug", type="string", example="iphone"),
     *                     @OA\Property(property="position", type="integer", example=2),
     *                     @OA\Property(property="description", type="string", nullable=true, example="Danh mục điện thoại iPhone"),
     *                     @OA\Property(property="parent_id", type="integer", example=1),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:30:00Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function getChildCategories($parent_id)
    {
        try {
            $categories = Category::where('parent_id', $parent_id)->get();

            return response()->json([
                'message' => 'Lấy danh sách danh mục con thành công',
                'data' => $categories
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy danh sách danh mục con thất bại", $th->getMessage());
        }
    }
}
