<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserAPIController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get authenticated user",
     *     tags={"User"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Fetch user successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Fetch user successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                 @OA\Property(property="avatar", type="string", example="avatars/johndoe.jpg"),
     *                 @OA\Property(property="gender", type="string", example="Male"),
     *                 @OA\Property(property="dob", type="string", format="date", example="1990-01-01"),
     *                 @OA\Property(property="phone", type="string", example="+123456789"),
     *                 @OA\Property(property="address", type="string", example="123 Street, City"),
     *                 @OA\Property(property="google_id", type="string", example=null),
     *                 @OA\Property(property="status", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */
    public function show()
    {
        try {
            $user = request()->user();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'message' => 'Fetch user successfully',
                'data' => $user
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/user/{id}",
     *     summary="Update user information",
     *     tags={"User"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", example="newpassword123"),
     *             @OA\Property(property="avatar", type="string", format="binary"),
     *             @OA\Property(property="gender", type="string", enum={"Male", "Female", "Other"}, example="Male"),
     *             @OA\Property(property="dob", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(property="phone", type="string", example="+123456789"),
     *             @OA\Property(property="address", type="string", example="123 Street, City"),
     *             @OA\Property(property="google_id", type="string", example=null),
     *             @OA\Property(property="status", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User updated successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                 @OA\Property(property="avatar", type="string", example="avatars/johndoe.jpg"),
     *                 @OA\Property(property="gender", type="string", example="Male"),
     *                 @OA\Property(property="dob", type="string", format="date", example="1990-01-01"),
     *                 @OA\Property(property="phone", type="string", example="+123456789"),
     *                 @OA\Property(property="address", type="string", example="123 Street, City"),
     *                 @OA\Property(property="google_id", type="string", example=null),
     *                 @OA\Property(property="status", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request)
    {
        try {
            $user = request()->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email',
                'password' => 'sometimes|string|min:6',
                'avatar' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'gender' => 'nullable|in:Male,Female,Other',
                'dob' => 'nullable|date',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'google_id' => 'nullable|string|max:255',
                'status' => 'boolean'
            ]);

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('users', 'public');
                $validated['avatar'] = $avatarPath;
            }

            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
