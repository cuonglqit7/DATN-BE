<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductReview;
use Illuminate\Support\Carbon;

class ProductReviewsSeeder extends Seeder
{
    public function run(): void
    {
        // Danh sách đánh giá mẫu dựa trên trải nghiệm thực tế
        $reviews = [
            "Sản phẩm chất lượng, hương vị tuyệt vời. Đóng gói cẩn thận, sẽ mua lại lần sau!",
            "Trà thơm, đậm vị, rất thích hợp để làm quà tặng. Người nhận rất hài lòng!",
            "Hộp quà thiết kế đẹp, sang trọng. Tuy nhiên, giá hơi cao so với mong đợi.",
            "Hương vị trà hơi nhạt so với khẩu vị của tôi, nhưng vẫn khá ổn.",
            "Dịch vụ giao hàng nhanh, đóng gói kỹ càng. Trà ngon hơn so với những loại tôi từng thử.",
            "Sản phẩm đúng mô tả, trà tươi và mùi thơm tự nhiên. Rất đáng tiền!",
            "Hộp gỗ đẹp, thích hợp làm quà biếu. Nhưng tôi mong muốn có thêm lựa chọn trọng lượng khác.",
            "Trà ngon nhưng hơi chát, có thể không phù hợp với ai thích vị nhẹ nhàng.",
            "Mua làm quà tặng cho bố mẹ, họ rất thích. Đóng gói tinh tế, mang lại cảm giác cao cấp.",
            "Không ấn tượng lắm, vị trà bình thường. Nhưng dịch vụ khách hàng rất tốt.",
            "Sản phẩm tuyệt vời! Từ bao bì đến chất lượng trà đều rất ổn.",
            "Trà có vị hậu ngọt, rất dễ chịu. Pha nhiều lần vẫn giữ được hương vị.",
            "Đóng gói đẹp, nhưng tôi mong đợi trà có hương thơm đậm hơn.",
            "Giá hơi cao nhưng xứng đáng với chất lượng. Hộp gỗ rất đẹp!",
            "Lần đầu mua thử, thực sự rất hài lòng. Sẽ ủng hộ dài lâu!"
        ];

        for ($productId = 1; $productId <= 30; $productId++) {
            $soLuongDanhGia = rand(10, 15); // Mỗi sản phẩm có từ 10 đến 15 đánh giá

            for ($i = 1; $i <= $soLuongDanhGia; $i++) {
                ProductReview::create([
                    'product_id' => $productId,
                    'user_id' => rand(1, 10), // Giả sử có 10 người dùng ngẫu nhiên
                    'rating' => rand(3, 5), // Chỉ chọn từ 3 đến 5 sao để phản ánh đánh giá thực tế
                    'comment' => $reviews[array_rand($reviews)], // Chọn ngẫu nhiên từ danh sách đánh giá thực tế
                    'status' => true,
                    'created_at' => Carbon::now()->subDays(rand(0, 30)), // Đánh giá trong vòng 30 ngày gần đây
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
