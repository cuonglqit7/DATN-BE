<?php

namespace App\Http\Controllers;

use App\Models\ArticleImage;
use Illuminate\Http\Request;

class ArticleImageController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            // Lấy tên gốc của file và phần mở rộng
            $extension = $file->getClientOriginalExtension();
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // Thêm timestamp để tránh trùng lặp
            $newFilename = $filename . '-' . time() . '.' . $extension;

            // Lưu file vào storage
            $path = $file->storeAs('articles/images', $newFilename, 'public');

            // Lưu vào database
            $image = ArticleImage::create(['path' => $path]);

            return response()->json([
                'uploaded' =>  true,
                'url' => asset('storage/' . $path)
            ]);
        }
        return response()->json(['error' => 'Upload failed'], 400);
    }
}
