<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Traits\SendResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use SendResponse;
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
