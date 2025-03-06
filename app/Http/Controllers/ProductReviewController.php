<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReview;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller
{
    /**
     * Lấy danh sách đánh giá của một sản phẩm (chỉ lấy đánh giá đã duyệt)
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

    /**
     * Kiểm tra từ cấm
     */
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
     * Tạo đánh giá mới
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
     * Cập nhật đánh giá
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
     * Xóa đánh giá
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

    /**
     * Quản trị viên duyệt đánh giá
     */
    public function approveReview($id)
    {
        $review = ProductReview::find($id);

        if (!$review) {
            return response()->json(['error' => 'Đánh giá không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $review->update(['status' => 1]);

        return response()->json(['message' => 'Đánh giá đã được duyệt'], Response::HTTP_OK);
    }

    /**
     * Quản trị viên từ chối đánh giá
     */
    public function rejectReview($id)
    {
        $review = ProductReview::find($id);

        if (!$review) {
            return response()->json(['error' => 'Đánh giá không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $review->update(['status' => 2]);

        return response()->json(['message' => 'Đánh giá đã bị từ chối'], Response::HTTP_OK);
    }
}
