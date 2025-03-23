<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthAPIController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Đăng nhập thành công"),
     *             @OA\Property(property="access_token", type="string", example="your-access-token")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function login(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $validated = $request->validate(
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ],
                [
                    'email.required' => 'Tài khoản không được bỏ trống.',
                    'email.email' => 'Tài khoản phải đăng nhập bằng email.',
                    'password.required' => 'Mật khẩu không được bỏ trống.'
                ]
            );

            // Tìm user theo email
            $user = User::where('email', $validated['email'])->first();

            // Kiểm tra xem email có tồn tại không
            if (!$user) {
                return response()->json([
                    'errors' => [
                        ['field' => 'email', 'message' => 'Email không tồn tại.']
                    ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422
            }

            // Kiểm tra mật khẩu
            if (!Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'errors' => [
                        ['field' => 'password', 'message' => 'Mật khẩu không chính xác.']
                    ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422
            }

            // Tạo token
            $token = $user->createToken('access_token')->plainTextToken;

            return response()->json([
                'message' => 'Đăng nhập thành công',
                'access_token' => $token,
            ], Response::HTTP_OK);
        } catch (ValidationException $th) {
            // Xử lý lỗi validation (các lỗi của Laravel)
            $errors = collect($th->errors())->map(function ($messages, $field) {
                return [
                    'field' => $field,
                    'message' => $messages[0], // Chỉ lấy lỗi đầu tiên của mỗi field
                ];
            })->values();

            return response()->json([
                'errors' => $errors,
            ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422

        } catch (\Throwable $th) {
            return response()->json([
                'errors' => [['field' => 'server', 'message' => 'Đã có lỗi xảy ra, vui lòng thử lại.']]
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // 500
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="User registration",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Registration successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Đăng ký thành công"),
     *             @OA\Property(property="access_token", type="string", example="your-auth-token")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function register(UserRequest $request)
    {
        try {
            $user = User::create($request->validated()); // Chỉ lấy dữ liệu hợp lệ từ request
            $user->syncRoles('user');
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Đăng ký thành công',
                'access_token' => $token,
            ], Response::HTTP_OK);
        } catch (\Illuminate\Database\QueryException $e) {
            if (
                str_contains($e->getMessage(), 'Integrity constraint violation') &&
                str_contains($e->getMessage(), 'Duplicate entry')
            ) {
                return response()->json([
                    'errors' => [
                        ['field' => 'email', 'message' => 'Email đã tồn tại']
                    ],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => collect($e->errors())
                    ->map(fn($messages, $field) => ['field' => $field, 'message' => $messages[0]])
                    ->values() // Chuyển thành array thay vì object
                    ->all()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => [['field' => 'unknown', 'message' => 'Có lỗi xảy ra, vui lòng thử lại!']]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }




    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="User logout",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Logout successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Đăng xuất thành công")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function logout()
    {
        try {
            request()->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Đăng xuất thành công'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(['email' => $validated['email']]);

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Vui lòng kiểm tra email của bạn!']);
        }

        throw ValidationException::withMessages(['email' => 'Gửi email thất bại!']);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $validated,
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Mật khẩu đã được cập nhật!']);
        }

        throw ValidationException::withMessages(['email' => 'Token không hợp lệ!']);
    }
}
