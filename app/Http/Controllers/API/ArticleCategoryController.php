<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleCategoryController extends Controller
{
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
