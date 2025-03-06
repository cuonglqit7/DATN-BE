<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\SendResponse;

class ProductController extends Controller
{
    use SendResponse;
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
