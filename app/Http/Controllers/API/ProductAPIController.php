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
            $limit = $request->limit ?? 8;

            $products = cache()->remember(
                "products",
                3600,
                fn() => Product::with('avatar')
                    ->orderBy('created_at', 'DESC')
                    ->paginate($limit)
            );
            if (!$products) {
                return $this->errorResponse("Products not found", "Not Found");
            }

            return $this->successResponse($products, "Fetch products successfully");
        } catch (\Throwable $th) {
            return $this->errorResponse("Fetch products fail", $th->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            $product = cache()->remember(
                "product_{$id}",
                3600,
                fn() => Product::with(['avatar', 'attributes', 'images', 'articles'])
                    ->findOrFail($id)
            );

            if (!$product) {
                return $this->errorResponse("Products not found", "Not Found");
            }

            return $this->successResponse($product, "Fetch product successfully");
        } catch (\Throwable $th) {
            return $this->errorResponse("Fetch products fail", $th->getMessage());
        }
    }
}
