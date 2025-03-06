<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Traits\SendResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use SendResponse;

    /**
     * @OA\Get(
     *     path="/api/banners",
     *     summary="Lấy danh sách banners",
     *     tags={"Banners"},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách banners thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách banners thành công"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="image_url", type="string", example="https://example.com/banner1.jpg"),
     *                     @OA\Property(property="alt_text", type="string", nullable=true, example="Banner quảng cáo sản phẩm A"),
     *                     @OA\Property(property="link", type="string", nullable=true, example="https://example.com/product-a"),
     *                     @OA\Property(property="position", type="integer", example=1),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-06T12:30:00Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Lấy danh sách banners thất bại",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lấy danh sách banners thất bại"),
     *             @OA\Property(property="errors", type="string", example="Lỗi server")
     *         )
     *     )
     * )
     */
    public function getAll()
    {
        try {
            $banners = Banner::orderBy('position', 'ASC')->get();

            return $this->successResponse($banners, "Lấy danh sách banners thành công");
        } catch (\Throwable $th) {
            return $this->errorResponse("Lấy danh sách banners thất bại", $th->getMessage());
        }
    }
}
