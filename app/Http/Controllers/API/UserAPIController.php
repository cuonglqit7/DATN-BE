<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAPIController extends Controller
{
    public function show()
    {
        return response()->json([
            'user' => request()->user()
        ]);
    }
}
