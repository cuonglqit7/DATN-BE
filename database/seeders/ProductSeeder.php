<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsTra = [
            ['Trà Ô Long', 'Trà Ô Long của Trà Việt là một sản phẩm trà đặc biệt được lấy từ đồn điền vùng Bảo Lộc, nơi nổi tiếng với sản xuất trà chất lượng cao. Được chọn lựa từ giống trà Ô Long Tứ Quý, sản phẩm này mang đến những trải nghiệm thưởng thức trà tuyệt vời.', 500000],
            ['Trà Cổ Thụ', 'Trà Cà Phê của Trà Việt là sự kết hợp độc đáo của hạt cà phê rang, hồng trà và cỏ ngọt. Hương thơm đặc trưng của loại trà này chắc chắn sẽ khiến bạn hài lòng như một tách cà phê sáng, hoặc thậm chí còn tốt hơn. Trà Cà Phê có mùi thơm đặc trưng của hạt cà phê rang, mùi hương này chắc chắn sẽ làm hài lòng cả những tín đồ của cà phê.', 150000],
            ['Trà Gạo Lức', 'Trà Gạo Lứt được kết hợp từ gạo lứt rang, cỏ ngọt và hồng trà. Có mùi thơm của gạo rang, vị ngọt thanh. Giúp giảm cholesterol xấu, và tăng cường sức khoẻ cho những người bị bệnh tim và tiểu đường.', 250000],
            ['Trà Gừng', ' Trà Gừng là một thức uống giàu năng lượng, không chứa nhiều caffeine như trà xanh hay cà phê. Được kết hợp giữa gừng, hồng trà và cỏ ngọt. Trà gừng có rất nhiều lợi ích cho sức khoẻ, giúp chống viêm và giảm các cơn đau, giảm các vấn đề về đường ruột, tiêu hoá, giảm cholesterol, hạ huyết áp, giảm các bệnh tim mạch …', 250000],
            ['Trà Hoa Cúc', 'Trà Hoa Cúc có vị đắng nhẹ, hơi the. Mùi thơm dịu nhẹ đặc trưng của hoa cúc. Giúp tâm trí và cơ thể thư giãn tốt nhất, thoát khỏi chứng mất ngủ dễ dàng hơn. Lựa chọn tốt để làm dịu những triệu chứng khó chịu của chứng khó tiêu hay đau dạ dày. Phù hợp cho phụ nữ và người lớn tuổi.', 300000],
            ['Trà Hoa Hồng', 'Trà Hoa Hồng được làm từ nụ hoa hồng, bằng cách sấy thăng hoa để giữ màu sắc và mùi thơm của trà. Chứa nhiều Vitamin C, vitamin B1, B2, K, β-carotene cùng các hoạt chất tanin, pectin giúp giảm viêm, chống nhiễm trùng, ngăn ngừa lão hoá sớm.', 400000],
            ['Trà Hoa Oải Hương', 'Trà Hoa Oải Hương (Trà Lavender) là sự kết hợp giữa hoa oải hương, trà Ô Long và cỏ ngọt. Là loại trà có hương thơm phổ biến và dễ chịu nhất thế giới. Được dùng như một cách trị liệu tại gia cho những người bị mất ngủ và bị các chứng rối loạn về giấc ngủ. Hỗ trợ bạn tiêu hoá tốt hơn, và bảo vệ bạn khỏi nhiễm trùng vì khả năng kháng khuẩn của nó.', 450000],
            ['Trà Hương Thảo', 'Trà Hương Thảo là sự kết hợp của lá hương thảo, cỏ ngọt và hồng trà. Mùi thơm nồng nàn, đặc trưng của hương thảo. Hương Thảo được biết đến như một trợ thủ đắc lực giúp cơ thể lưu thông máu đến não tốt hơn, vì thế, nó có khả năng giúp bạn chống lại các bệnh thoái hoá não như Alzheimer, và tăng cường trí nhớ. Uống Trà Hương Thảo mỗi ngày sẽ giúp bạn giảm tress hiệu quả.', 350000],
            ['Trà Lài', 'Trà Lài là sự kết hợp độc đáo của trà xanh Thái Nguyên và những búp hoa lài hàm tiếu Hương thơm dịu nhẹ, nồng nàn của hoa lài tươi. Màu nước vàng xanh, vị chát vừa, hậu ngọt. Trà Lài có rất nhiều tác dụng tốt cho sức khoẻ như: ngăn ngừa các bệnh Alzheimer và Parkinson, giảm nguy cơ bị tiểu đường, hỗ trợ giảm cân, tăng cường chức năng não…', 500000],
            ['Trà Ô Long Nhân Sâm', 'Trà Ô long nhân sâm là sự kết hợp của Trà Ô Long cao cấp, hoa mộc, nhân sâm và cam thảo. Trà có hương thơm ngọt của hoa mộc, vị ngọt đượm rất dễ chịu. Pha được nhiều lần nước. Trà Ô Long Nhân Sâm giúp hỗ trợ tiêu hóa và làm ấm dạ dày, giảm bớt các triệu chứng của bệnh eczema và bệnh vẩy nến, tăng cường hệ miễn dịch… Thường được chọn để làm quà tặng cho người lớn tuổi, phụ nữ…', 1000000],
        ];

        $productsAmTra = [
            ['Hộp Quà Bộ Ấm Trà Thuỷ Tinh Như Ý', 'Hộp quà bộ ấm trà thuỷ tinh Như Ý có kích thước 18 cm x 34 cm x 7 cm. Chất liệu giấy gân mỹ thuật màu đỏ. Mặt trên in hoa văn sen cách điệu, ép kim bạc logo Trà Việt. Bên trong là một hộp trà với 12 gói nhỏ tiện dụng và một bộ ấm thuỷ tinh cao cấp cho những trải nghiệm tuyệt vời hơn khi dùng trà.', 1075000],
            ['Bộ ấm trà Bách Niên', 'Dung tích ấm cỡ lớn 1,5 lít cùng 4 tách 300ml, có khay gỗ riêng cho từng tách trà và ấm. Chất liệu sứ được tạo hình mặt men da bưởi, kế hợp gỗ cao su tự nhiên. Tạo dáng theo phong cách hiện đại đơn giản. Phù hợp với không gian phòng khách gia đình và văn phòng.', 645000],
            ['Hộp quà Bộ ấm trà thuỷ tinh Đối ẩm', 'Hộp quà – Bộ Ấm Trà Thuỷ Tinh Đối Ẩm có kích thước 22 x 22 x 10cm. Bên ngoài là hộp quà bằng chất liệu giấy mỹ thuật cao cấp, logo ép nhũ vàng, tạo nên sự hài hoà và sang trọng cho bộ sản phẩm. Bên trong gồm 1 hộp trà 75g chất liệu thiếc, một ấm pha trà và hai chén uống trà bằng thuỷ tinh cao cấp, trong suốt, được làm thủ công hoàn toàn, chịu nhiệt tốt.', 833000],
            ['Hộp Quà Bộ Ấm Trà Thuỷ Tinh Tứ Ẩm', 'Hộp quà – Bộ ấm trà thuỷ tinh tứ ẩm, có kích thước 26 x 26 x 10cm. Bên ngoài là hộp quà có logo được ép kim trên nền chất liệu giấy mỹ thuật tạo nên sự hài hoà và sang trọng. Bên trong gồm 2 hộp trà 75g chất liệu thiếc, một ấm pha trà và bốn chén uống trà bằng thuỷ tinh cao cấp, trong suốt, được làm thủ công hoàn toàn.', 1257000],
            ['Hộp Quà Bộ Ấm Trà Sứ Trắng Tứ Ẩm', 'Hộp Quà Bộ Ấm Trà Sứ Trắng Tứ Ẩm có kích thước 26 x 26 x 9cm. Bên ngoài hộp là chất liệu giấy mỹ thuật đen – đỏ. Hoa văn ép kim nhũ vàng sang trọng. Bên trong gồm 2 hộp trà 75g chất liệu thiếc, một ấm pha trà và bốn chén uống trà bằng sứ trắng cao cấp, được làm theo công nghệ hiện đại, đem đến trải nghiệm thú vị hơn cho người dùng.', 1379000],
            ['Hộp Quà Bộ Ấm Trà Thuỷ Tinh Lục Ẩm', 'Hộp Quà – Bộ ấm trà thuỷ tinh lục ẩm có kích thước 30 x 30 x 9cm. Bên ngoài là hộp quà cứng, sang trọng bằng chất liệu giấy mỹ thuật đen – đỏ. Hoa văn ép kim nhũ vàng sang trọng. Bên trong gồm 3 hộp trà 75g chất liệu thiếc. Một ấm pha trà và sáu chén uống trà bằng thuỷ tinh cao cấp, trong suốt, được làm thủ công hoàn toàn.', 1728000],
        ];

        $productsHat = [
            ['Quà tặng người sành trà – trà Nõn tôm, Hạt mix 5 loại hạt', 'Bên trong hộp quà gồm 01 hộp Trà Nõn tôm và 01 hộp hạt dinh dưỡng mix ngũ hạt: hạt điều, hạt sen, hạt hạnh nhân, hạt dẻ cười, hạt macca. Hộp trà An Khang, chất liệu giấy mĩ thuật màu đỏ, có gân. Mặt trên kéo lụa hoa văn tranh Đông Hồ “Cóc múa lân” và logo Trà Việt. Bên trong là 2 hộp vuông nhỏ, chất liệu giấy mĩ thuật. Trà được đóng gói 8g hút chân không, mỗi hộp chứa 10 gói trà 8g tiện dụng cho người dùng. Hạt được đóng gói mỗi túi 25g hút chân không, gồm 06 túi hạt nhỏ trong một hộp. Bộ quà tặng dành cho dịp ghé thăm bạn bè, đối tác thường xuyên, tặng phụ nữ, người lớn tuổi.', 665000],
            ['Quà tặng đối tác – Trà Ô Long, Hạt Macca', 'Bên trong hộp quà gồm 01 hộp Trà Ô Long và 01 hộp hạt Macca. Hộp trà Tri Kỷ, chất liệu giấy mĩ thuật có cán gân màu đỏ, được bồi chắc chắn. Trên mặt hộp kéo lụa hoa văn “Mục đồng thổi sáo” và dán logo Trà Việt bằng giấy couche. Bên trong đệm giấy nghệ thuật đen, có 02 hộp bát giác mầu đỏ. Trà được đóng gói 100g hút chân không, bên ngoài là hộp giấy mỹ thuật. Hạt được đóng gói mỗi túi 25g hút chân không, gồm 05 túi hạt nhỏ trong một hộp bát giác. Trà Cổ Thụ được thu hái từ những cây trà hàng trăm năm tuổi mọc ở đỉnh núi Tà Xùa – Sơn La. Trà có hương thơm lạ, phảng phất mùi khói bếp, màu nước vàng, sánh như mật ong. Vị chát đượm, hậu ngọt và lưu giữ hậu vị rất lâu. Hạt macca có độ giòn, vị mềm mượt như bơ, có vị béo, bùi và ngọt hạt. Đây là loại hạt giàu calo, có chứa nhiều chất béo, vitamin và các loại khoáng chất thiết yếu có lợi cho sức khỏe. Bộ quà tặng dành cho dịp ghé thăm bạn bè, đối tác thường xuyên, tặng người lớn tuổi.', 466000],
            ['Quà tặng Ông Bà – Trà Phổ Nhĩ, hạt sen, hạt dẻ cười', 'Bên trong hộp quà gồm 01 hộp Trà Phổ Nhĩ, 01 hộp hạt sen và 01 hộp hạt dẻ cười. Hộp trà Tri Ân, chất liệu giấy mĩ thuật cán gân màu đỏ, được bồi chắc chắn. Trên mặt hộp kéo lụa hoa văn “Mục đồng thổi sáo” và dán logo Trà Việt bằng giấy couche. Bên trong đệm giấy nghệ thuật đen, có 03 hộp trà bát giác mầu đỏ. Trà được đóng gói 100g hút chân không và để trong hộp giấy mỹ thuật. Hạt được đóng gói mỗi túi 25g hút chân không, gồm 05 túi hạt nhỏ trong một hộp.', 815000],
            ['Quà tặng phụ nữ – Hồng Trà, hạt Sen', 'Hạt sen có độ giòn, vị ngọt thanh của hạt, bùi, ngậy. Hạt sen là loại hạt ít calo và chất béo, nhưng lại rất giàu protein thực vật và chất xơ. Ngoài ra, hạt sen cũng là nguồn cung cấp các vitamin B phức hợp, vitamin C, magie, kali, phốt pho…', 761000],
        ];

        $productsTet = [
            ['Hộp quà Tết cao cấp Tâm Phúc Trà Việt', 'Hộp quà tết cao cấp Tâm Phúc Trà Việt QT02, thích hợp làm quà tết cho nhân viên, bạn bè hoặc bỏ trong các giỏ quà tết. 01 hộp Trà Thái Nguyên thượng hạng được chọn lựa bởi các Tea Master của Trà Việt.', 761000],
            ['Set quà tết ý nghĩa gồm trà, ấm chén và hạt', 'Hộp quà Ấm trà sứ Tứ Ẩm, hộp quà cứng, nắp nam châm, chất liệu giấy mĩ thuật cán gân cao cấp, thích hợp làm hộp quà tết. 01 bộ ấm trà sứ cao cấp, gồm 01 ấm kiểu quai chuôi lạ mắt và 04 chén uống trà. 01 hộp trà Nõn Tôm cao cấp, trọng lượng 60g hút chân không. 01 hộp hạt dinh dưỡng mix 5 loại hạt: sen, điều, macca, dẻ cười, hạnh nhân', 944000],
            ['Quà tết sức khoẻ tặng người lớn tuổi', 'Hộp quà An Khang, chất liệu giấy mĩ thuật cao cấp. Hộp quà cứng, nắp nam châm sang trọng, thích hợp để làm hộp quà tết.', 552000],
            ['Hộp quà Tết Như Ý', 'Hộp quà Như Ý, hộp quà cứng, nắp nam châm, chất liệu giấy mĩ thuật cán gân cao cấp, thích hợp làm hộp quà tết. Mỗi hộp quà sẽ đi kèm với 1 túi đựng hộp quà, 1 quyển sách “Chuyện trà”, bao lì xì và 1 thiệp chúc mừng năm mới', 1101000],
            ['Set quà Tết sang trọng tặng khách hàng', 'Trà Ô Long, Trà Thái Nguyên, Trà Shan Tuyết, Trà Sen thượng hạng được chọn lựa bởi các tea master của Trà Việt. Hộp Quà Tứ Quý được làm từ giấy mỹ thuật ép kim sang trọng thích hợp để làm quà tết Mỗi hộp quà sẽ đi kèm với 1 túi giấy, 1 quyển “Chuyện trà” và 1 thiệp chúc mừng năm mới.', 761000],
        ];

        $productsTrungThu = [
            ['Trà Sen, Bánh Khoai Môn Lá Cẩm', 'Hộp Quà An Khang: Hộp cứng, chất liệu giấy mỹ thuật cán gân cao cấp, kéo lụa tranh múa lân Đông Hồ. TẶNG KÈM: Túi đựng quà, thiệp chúc Trung Thu và cẩm nang “Chuyện trà”', 410000],
            ['Trà Lài, Bánh Đậu Xanh Lá Dứa', 'Hộp Quà An Khang: Hộp cứng, chất liệu giấy mỹ thuật cán gân cao cấp, kéo lụa tranh múa lân Đông Hồ. TẶNG KÈM: túi đựng quà, thiệp chúc Trung Thu và cẩm nang “Chuyện trà”.', 451000],
            ['Trà Sâm Dứa, Bánh Gạo Đỏ Hạt Sen', 'Hộp Quà An Khang: Hộp cứng, chất liệu giấy mỹ thuật cán gân cao cấp, kéo lụa tranh múa lân Đông Hồ. TẶNG KÈM: túi đựng quà, thiệp chúc Trung Thu và cẩm nang “Chuyện trà”.', 462000],
            ['Bánh Gạo Đỏ Hạt Sen, Bánh Matcha Đậu Xanh', 'Hộp Quà An Khang: Hộp cứng, chất liệu giấy mỹ thuật cán gân cao cấp, kéo lụa tranh múa lân Đông Hồ. TẶNG KÈM: Túi đựng quà, thiệp chúc Trung Thu và cẩm nang “Chuyện trà”.', 446000],
            ['Trà Sen, Trà Lài, Bánh Khoai Môn Lá Cẩm, Bánh Đậu Xanh Lá Dứa', 'Hộp Quà Thịnh Vượng: Hộp cứng, chất liệu giấy mỹ thuật cán gân cao cấp, kéo lụa tranh múa lân Đông Hồ. TẶNG KÈM: Túi đựng quà, thiệp chúc Trung Thu và cẩm nang “Chuyện trà”.', 772000],
        ];

        foreach ($productsTra as $key => $product) {
            Product::create([
                'product_name' => $product[0],
                'slug' => Str::slug($product[0]),
                'description' => $product[1],
                'price' => $product[2],
                'promotion_price' => $product[2] - ($product[2] * 0.2),
                'quantity_in_stock' => rand(10, 100),
                'quantity_sold' => rand(0, 50),
                'category_id' => 1,
            ]);
        }

        foreach ($productsAmTra as $key => $product) {
            Product::create([
                'product_name' => $product[0],
                'slug' => Str::slug($product[0]),
                'description' => $product[1],
                'price' => $product[2],
                'promotion_price' => $product[2] - ($product[2] * 0.4),
                'quantity_in_stock' => rand(10, 100),
                'quantity_sold' => rand(0, 50),
                'category_id' => 2,
            ]);
        }

        foreach ($productsHat as $key => $product) {
            Product::create([
                'product_name' => $product[0],
                'slug' => Str::slug($product[0]),
                'description' => $product[1],
                'price' => $product[2],
                'promotion_price' => $product[2] - ($product[2] * 0.5),
                'quantity_in_stock' => rand(10, 100),
                'quantity_sold' => rand(0, 50),
                'category_id' => 3,
            ]);
        }

        foreach ($productsTet as $key => $product) {
            Product::create([
                'product_name' => $product[0],
                'slug' => Str::slug($product[0]),
                'description' => $product[1],
                'price' => $product[2],
                'promotion_price' => $product[2] - ($product[2] * 0.2),
                'quantity_in_stock' => rand(10, 100),
                'quantity_sold' => rand(0, 50),
                'category_id' => 6,
            ]);
        }

        foreach ($productsTrungThu as $key => $product) {
            Product::create([
                'product_name' => $product[0],
                'slug' => Str::slug($product[0]),
                'description' => $product[1],
                'price' => $product[2],
                'promotion_price' => $product[2] - ($product[2] * 0.45),
                'quantity_in_stock' => rand(10, 100),
                'quantity_sold' => rand(0, 50),
                'category_id' => 5,
            ]);
        }
    }
}
