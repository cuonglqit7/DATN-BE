<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleCategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/articleCategories",
     *     summary="Lấy danh sách danh mục bài viết",
     *     tags={"Article Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách danh mục bài viết thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách danh mục bài viết thành công"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Công nghệ"),
     *                     @OA\Property(property="slug", type="string", example="cong-nghe"),
     *                     @OA\Property(property="position", type="integer", example=1),
     *                     @OA\Property(property="description", type="string", example="Danh mục về công nghệ"),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:30:00Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lấy danh sách danh mục bài viết thất bại",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách danh mục bài viết thất bại"),
     *             @OA\Property(property="errors", type="string", example="Lỗi server")
     *         )
     *     )
     * )
     */

    public function getAll()
    {
        try {
            $categories = ArticleCategory::orderBy('position', 'ASC')->get();

            return response()->json([
                'message' => 'Lấy danh sách danh mục bài viết thánh công',
                'data' => $categories
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy danh sách danh mục bài viết thất bại", $th->getMessage());
        }
    }
}
