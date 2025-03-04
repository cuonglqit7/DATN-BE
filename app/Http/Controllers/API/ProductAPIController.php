<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\SendResponse;

class ProductAPIController extends Controller
{
    use SendResponse;
    public function getAll(Request $request)
    {
        try {
            $limit = is_numeric($request->limit) ? (int) $request->limit : 8;

            $query = Product::with('category');

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

            // Lọc theo trạng thái
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            // Phân trang
            $products = $query->orderBy('created_at', 'DESC')->paginate($limit);

            return $this->successResponse($products, "Fetch products successfully");
        } catch (\Throwable $th) {
            return $this->errorResponse("Fetch products fail", $th->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            $product = Product::with('category')->find($id);

            if (!$product) {
                return $this->errorResponse("Products not found", "Not Found");
            }

            return $this->successResponse($product, "Fetch product successfully");
        } catch (\Throwable $th) {
            return $this->errorResponse("Fetch products fail", $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:products,slug,' . $id,
            'price' => 'sometimes|numeric|min:0',
            'promotion_price' => 'nullable|numeric|min:0',
            'quantity_in_stock' => 'sometimes|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product->update($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->images()->create(['image_url' => $path]);
        }

        return $this->successResponse($product, "Updated product successfully");
    }
}
