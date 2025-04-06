<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    public function sendResetLink(Request $request)
    {
        // Validate email
        $request->validate(['email' => 'required|email']);

        // Gửi email reset password
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Hãy kiểm tra email vừa nhập!'], 200);
        }

        return response()->json(['error' => 'Không thể kết nối email.'], 400);
    }

    use SendsPasswordResetEmails;
}
