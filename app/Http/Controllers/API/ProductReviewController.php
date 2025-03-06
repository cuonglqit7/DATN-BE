<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReview;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Product Reviews",
 *     description="API đánh giá sản phẩm"
 * )
 */
class ProductReviewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products/{product_id}/reviews",
     *     summary="Lấy danh sách đánh giá của một sản phẩm",
     *     tags={"Product Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="path",
     *         required=true,
     *         description="ID của sản phẩm",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách đánh giá",
     *         @OA\JsonContent(
     *             @OA\Property(property="reviews", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="user", type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="name", type="string", example="Nguyễn Văn A")
     *                     ),
     *                     @OA\Property(property="rating", type="integer", example=5),
     *                     @OA\Property(property="comment", type="string", example="Sản phẩm rất tốt!"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-06T12:00:00Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getReviewsByProduct($product_id)
    {
        $reviews = ProductReview::where('product_id', $product_id)
            ->where('status', 1) // Chỉ lấy đánh giá được duyệt
            ->with('user:id,name')
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['reviews' => $reviews], Response::HTTP_OK);
    }


    private function containsBannedWords($text)
    {
        $badWords = config('banned_words.bad_words');
        foreach ($badWords as $word) {
            if (stripos($text, $word) !== false) {
                return true;
            }
        }
        return false;
    }


    /**
     * @OA\Post(
     *     path="/api/reviews",
     *     summary="Tạo đánh giá mới",
     *     tags={"Product Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(property="rating", type="integer", example=4),
     *             @OA\Property(property="comment", type="string", example="Chất lượng khá ổn!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Đánh giá đã được thêm",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Đánh giá đã được thêm thành công"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="product_id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=2),
     *                 @OA\Property(property="rating", type="integer", example=4),
     *                 @OA\Property(property="comment", type="string", example="Chất lượng khá ổn!"),
     *                 @OA\Property(property="status", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function createReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $status = 1; // Mặc định là "được duyệt"
        if ($request->comment && $this->containsBannedWords($request->comment)) {
            $status = 0; // Đánh giá sẽ cần kiểm duyệt
        }

        $review = ProductReview::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => $status,
        ]);

        return response()->json([
            'message' => $status == 1 ? 'Đánh giá đã được thêm thành công' : 'Đánh giá đang chờ duyệt do chứa từ không hợp lệ',
            'data' => $review
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/reviews/{id}",
     *     summary="Cập nhật đánh giá",
     *     tags={"Product Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID của đánh giá",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="rating", type="integer", example=5),
     *             @OA\Property(property="comment", type="string", example="Sản phẩm thực sự tuyệt vời!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Đánh giá đã được cập nhật",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Đánh giá đã được cập nhật"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="rating", type="integer", example=5),
     *                 @OA\Property(property="comment", type="string", example="Sản phẩm thực sự tuyệt vời!")
     *             )
     *         )
     *     )
     * )
     */
    public function updateReview(Request $request, $id)
    {
        $review = ProductReview::find($id);

        if (!$review) {
            return response()->json(['error' => 'Đánh giá không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $status = 1;
        if ($request->comment && $this->containsBannedWords($request->comment)) {
            $status = 0;
        }

        $review->update([
            'rating' => $request->rating ?? $review->rating,
            'comment' => $request->comment ?? $review->comment,
            'status' => $status
        ]);

        return response()->json([
            'message' => $status == 1 ? 'Đánh giá đã được cập nhật' : 'Đánh giá đang chờ duyệt do chứa từ không hợp lệ',
            'data' => $review
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/reviews/{id}",
     *     summary="Xóa đánh giá",
     *     tags={"Product Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID của đánh giá",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Đánh giá đã bị xóa",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Đánh giá đã bị xóa")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Đánh giá không tồn tại",
     *                @OA\Property(property="error", type="string", example="Đánh giá không tồn tại")
     *         )
     *     )
     * )
     */
    public function deleteReview($id)
    {
        $review = ProductReview::find($id);

        if (!$review) {
            return response()->json(['error' => 'Đánh giá không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $review->delete();

        return response()->json(['message' => 'Đánh giá đã bị xóa'], Response::HTTP_OK);
    }
}
