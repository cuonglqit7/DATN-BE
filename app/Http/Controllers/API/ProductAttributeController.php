<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Traits\SendResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductAttributeController extends Controller
{
    use SendResponse;

    public function getAllGroupedAttributes()
    {
        try {
            $attributes = ProductAttribute::select('attribute_name', 'attribute_value')
                ->selectRaw('COUNT(product_id) as product_count')
                ->groupBy('attribute_name', 'attribute_value')
                ->orderBy('attribute_name', 'ASC')
                ->get()
                ->groupBy('attribute_name')
                ->map(function ($group) {
                    return $group->map(function ($item) {
                        return [
                            'value' => $item->attribute_value,
                            'count' => $item->product_count
                        ];
                    })->values();
                });

            if ($attributes->isEmpty()) {
                return response()->json([
                    'message' => 'No attributes found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'message' => 'Fetch all grouped attributes successfully',
                'data' => $attributes,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to fetch attributes',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    public function getAttributesByProduct($product_id)
    {
        try {
            $attributes = ProductAttribute::where('product_id', $product_id)->get();

            if ($attributes->isEmpty()) {
                return response()->json([
                    'message' => 'No attributes found for this product',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'message' => 'Fetch product attributes successfully',
                'data' => $attributes,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to fetch attributes',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
