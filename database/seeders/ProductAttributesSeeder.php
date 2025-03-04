<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductAttributesSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        // Danh sách thuộc tính mẫu dành cho trà và quà tặng trà
        $attributes = [
            ['attribute_name' => 'Xuất xứ', 'attribute_value' => 'Việt Nam'],
            ['attribute_name' => 'Loại trà', 'attribute_value' => 'Trà Xanh'],
            ['attribute_name' => 'Đóng gói', 'attribute_value' => 'Hộp 250g'],
            ['attribute_name' => 'Hạn sử dụng', 'attribute_value' => '12 tháng'],
            ['attribute_name' => 'Loại quà tặng', 'attribute_value' => 'Hộp Quà Tặng Sang Trọng'],
            ['attribute_name' => 'Chất liệu hộp', 'attribute_value' => 'Gỗ cao cấp'],
        ];

        // Gán 3 thuộc tính ngẫu nhiên cho mỗi sản phẩm
        foreach ($products as $product) {
            $randomAttributes = collect($attributes)->random(3);

            foreach ($randomAttributes as $attr) {
                DB::table('product_attributes')->insert([
                    'product_id' => $product->id,
                    'attribute_name' => $attr['attribute_name'],
                    'attribute_value' => $attr['attribute_value'],
                    'status' => true,
                ]);
            }
        }
    }
}
