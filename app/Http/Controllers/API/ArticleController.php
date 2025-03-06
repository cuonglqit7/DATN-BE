<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\SendResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use SendResponse;
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
}
