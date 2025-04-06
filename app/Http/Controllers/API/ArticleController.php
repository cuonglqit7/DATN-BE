<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\SendResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    use SendResponse;

    /**
     * @OA\Get(
     *     path="/api/articles",
     *     summary="Lấy danh sách bài viết",
     *     tags={"Articles"},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách bài viết thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách bài viết thành công"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Bài viết về công nghệ"),
     *                     @OA\Property(property="slug", type="string", example="bai-viet-ve-cong-nghe"),
     *                     @OA\Property(property="thumbnail_url", type="string", example="https://example.com/image.jpg"),
     *                     @OA\Property(property="short_desciption", type="string", example="Tóm tắt bài viết"),
     *                     @OA\Property(property="content", type="string", example="Nội dung chi tiết bài viết"),
     *                     @OA\Property(property="product_id", type="integer", nullable=true, example=5),
     *                     @OA\Property(property="user_id", type="integer", example=2),
     *                     @OA\Property(property="article_category_id", type="integer", example=3),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:30:00Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lấy danh sách bài viết thất bại",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách bài viết thất bại"),
     *             @OA\Property(property="errors", type="string", example="Lỗi server")
     *         )
     *     )
     * )
     */
    public function getAll()
    {
        try {
            $articles = Article::with('user', 'articleCategory')
                ->orderBy('created_at', 'DESC')
                ->get();

            return $this->successResponse($articles, "Lấy danh sách bài viết thánh công");
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy danh sách bài viết thất bại", $th->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/articles/{id}",
     *     summary="Lấy chi tiết bài viết",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID của bài viết",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lấy chi tiết bài viết thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy chi tiết bài viết thành công"),
     *             @OA\Property(property="data",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Bài viết về công nghệ"),
     *                 @OA\Property(property="slug", type="string", example="bai-viet-ve-cong-nghe"),
     *                 @OA\Property(property="thumbnail_url", type="string", example="https://example.com/image.jpg"),
     *                 @OA\Property(property="short_desciption", type="string", example="Tóm tắt bài viết"),
     *                 @OA\Property(property="content", type="string", example="Nội dung chi tiết bài viết"),
     *                 @OA\Property(property="product_id", type="integer", nullable=true, example=5),
     *                 @OA\Property(property="user_id", type="integer", example=2),
     *                 @OA\Property(property="article_category_id", type="integer", example=3),
     *                 @OA\Property(property="status", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:30:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không tìm thấy bài viết",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy chi tiết bài viết thất bại"),
     *             @OA\Property(property="errors", type="string", example="Không tìm thấy")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lỗi server",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy chi tiết bài viết thất bại"),
     *             @OA\Property(property="errors", type="string", example="Lỗi server")
     *         )
     *     )
     * )
     */
    public function getById(string $id)
    {
        try {
            $article = Article::with('user', 'articleCategory', 'product')->find($id);

            if (!$article) {
                return $this->errorResponse("Lấy chi tiết bài viết thất bại", "Không tìm thấy");
            }

            return $this->successResponse($article, "Lấy chi tiết bài viết thành công");
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy chi tiết bài viết thất bại", $th->getMessage());
        }
    }

    public function getArticleProducts(Request $request, string $id)
    {
        try {

            $articles = Article::where('product_id', $id)
                ->where('status', 1)->orderBy('created_at', 'desc')
                ->paginate(4);

            if (!$articles) {
                return $this->errorResponse("Lấy bài viết về sản phẩm thất bại", "Không tìm thấy");
            }

            $articles->getCollection()->transform(function ($article) {
                $article->thumbnail_url = $article->thumbnail_url
                    ? asset(Storage::url($article->thumbnail_url))
                    : null;
                return $article;
            });

            return $this->successResponse($articles, "Lấy chi tiết bài viết thành công");
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy chi tiết bài viết thất bại", $th->getMessage());
        }
    }
}
