<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            $categories = Category::orderBy('position', 'ASC')->get();

            return response()->json([
                'message' => 'Lấy danh sách danh mục sản phẩm thành công',
                'data' => $categories
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy danh sách danh mục sản phẩm thất bại", $th->getMessage());
        }
    }

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
