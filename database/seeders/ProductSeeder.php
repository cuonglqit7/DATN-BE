<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['Trà Xanh Thái Nguyên', 'Green Tea Thai Nguyen', 100000, 'Việt Nam'],
            ['Trà Ô Long Đặc Biệt', 'Oolong Special Tea', 150000, 'Việt Nam'],
            ['Trà Sen Tây Hồ', 'Lotus Tea West Lake', 200000, 'Việt Nam'],
            ['Trà Lài Ngọc Bích', 'Jasmine Jade Tea', 120000, 'Việt Nam'],
            ['Trà Đen Ceylon', 'Ceylon Black Tea', 130000, 'Sri Lanka'],
            ['Trà Phổ Nhĩ Chín', 'Ripe Pu-erh Tea', 250000, 'Trung Quốc'],
            ['Trà Phổ Nhĩ Sống', 'Raw Pu-erh Tea', 300000, 'Trung Quốc'],
            ['Trà Sâm Hàn Quốc', 'Korean Ginseng Tea', 350000, 'Hàn Quốc'],
            ['Trà Gừng Mật Ong', 'Ginger Honey Tea', 90000, 'Việt Nam'],
            ['Trà Chanh Mật Ong', 'Lemon Honey Tea', 95000, 'Việt Nam'],
            ['Trà Bạc Hà', 'Mint Tea', 85000, 'Việt Nam'],
            ['Trà Atiso Đà Lạt', 'Artichoke Tea Da Lat', 110000, 'Việt Nam'],
            ['Trà Thảo Mộc An Nhiên', 'Herbal Serenity Tea', 125000, 'Việt Nam'],
            ['Trà Matcha Nhật Bản', 'Japanese Matcha Tea', 280000, 'Nhật Bản'],
            ['Trà Sữa Trân Châu', 'Bubble Milk Tea', 105000, 'Đài Loan'],
            ['Trà Quế Hồi', 'Cinnamon Star Anise Tea', 135000, 'Việt Nam'],
            ['Trà Chùm Ngây', 'Moringa Tea', 95000, 'Việt Nam'],
            ['Trà Gạo Lứt', 'Brown Rice Tea', 100000, 'Việt Nam'],
            ['Trà Táo Đỏ', 'Red Date Tea', 120000, 'Hàn Quốc'],
            ['Trà Sả Chanh', 'Lemongrass Lemon Tea', 105000, 'Việt Nam'],
        ];

        foreach ($products as $index => $product) {
            DB::table('products')->insert([
                'product_code' => 'TRA' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'name' => $product[0],
                'slug' => Str::slug($product[1]),
                'price' => $product[2],
                'position' => $index + 1,
                'short_description' => 'Một loại trà hảo hạng với hương vị đặc trưng.',
                'long_description' => 'Trà được chế biến từ những nguyên liệu tốt nhất, mang lại trải nghiệm thưởng thức trà tinh tế.',
                'stock' => rand(50, 200),
                'number_purchases' => rand(0, 500),
                'made_in' => $product[3],
                'status' => 'active',
                'brand_id' => rand(1, 5),
                'sub_category_id' => rand(1, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
