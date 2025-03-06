<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Traits\SendResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductImageController extends Controller
{
    use SendResponse;
    public function getAvatar(string $product_id)
    {
        try {
            $avatar = ProductImage::where('product_id', $product_id)
                ->where('is_primary', true)->first();

            if (!$avatar) {
                return response()->json([
                    'message' => 'Avatar not found',
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'message' => 'Fetch avatars successfully',
                'data' => asset('storage/ ' . $avatar . ''),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse("Fetch avatar fail", $th->getMessage());
        }
    }

    public function getAll(string $product_id)
    {
        try {
            $images = ProductImage::where('product_id', $product_id)->orderBy('is_primary', 'DESC')->get();

            if (!$images) {
                return response()->json([
                    'message' => 'Images not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'message' => 'Fetch images success',
                'data' => $images->map(function ($image) {
                    return [
                        'image_url' => asset('storage/' . $image->image_url),
                        'alt_text' => $image->alt_text,
                    ];
                })
            ]);
        } catch (\Throwable $th) {
            return $this->errorResponse("Fetch images fail", $th->getMessage());
        }
    }
}
