<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            Mail::to('lequoccuong207@gmail.com')->send(new ContactMail($request->all()));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Tin nhắn đã được ghi nhận, nhưng có lỗi khi gửi email: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Tin nhắn của bạn đã được gửi thành công!',
        ], 200);
    }
}
