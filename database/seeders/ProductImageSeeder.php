<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $urls1 = [
            'banh-gao-do-hat-sen-banh-matcha-dau-xanh-1.jpg',
            'banh-gao-do-hat-sen-banh-matcha-dau-xanh-2.jpg',
            'banh-gao-do-hat-sen-banh-matcha-dau-xanh-3.jpg',
            'banh-gao-do-hat-sen-banh-matcha-dau-xanh-4.jpg',
        ];
        foreach ($urls1 as $url) {
            ProductImage::create([
                'product_id' => 29,
                'image_url' => $url,
                'alt_text' => $url,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $urls2 = [
            'bo-am-tra-bach-nien-1.jpg',
            'bo-am-tra-bach-nien-2.jpg',
            'bo-am-tra-bach-nien-3.jpg',
            'bo-am-tra-bach-nien-4.jpg',
        ];
        foreach ($urls2 as $url) {
            ProductImage::create([
                'product_id' => 12,
                'image_url' => $url,
                'alt_text' => $url,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $urls3 = [
            'hop-qua-bo-am-tra-su-trang-tu-am-1.jpg',
            'hop-qua-bo-am-tra-su-trang-tu-am-2.jpg',
            'hop-qua-bo-am-tra-su-trang-tu-am-3.jpg',
            'hop-qua-bo-am-tra-su-trang-tu-am-4.jpg',
        ];
        foreach ($urls3 as $url) {
            ProductImage::create([
                'product_id' => 15,
                'image_url' => $url,
                'alt_text' => $url,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $urls3 = [
            'hop-qua-bo-am-tra-thuy-tinh-doi-am-1.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-doi-am-3.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-doi-am-4.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-doi-am-2.jpg',
        ];
        foreach ($urls3 as $url) {
            ProductImage::create([
                'product_id' => 13,
                'image_url' => $url,
                'alt_text' => $url,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $urls4 = [
            'hop-qua-bo-am-tra-thuy-tinh-luc-am-1.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-luc-am-2.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-luc-am-3.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-luc-am-4.jpg',
        ];
        foreach ($urls4 as $url) {
            ProductImage::create([
                'product_id' => 16,
                'image_url' => $url,
                'alt_text' => $url,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $urls5 = [
            'hop-qua-bo-am-tra-thuy-tinh-nhu-y-1.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-nhu-y-2.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-nhu-y-3.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-nhu-y-4.jpg',
        ];
        foreach ($urls5 as $url) {
            ProductImage::create([
                'product_id' => 11,
                'image_url' => $url,
                'alt_text' => $url,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $urls6 = [
            'hop-qua-bo-am-tra-thuy-tinh-tu-am-1.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-tu-am-2.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-tu-am-3.jpg',
            'hop-qua-bo-am-tra-thuy-tinh-tu-am-4.jpg',
        ];
        foreach ($urls6 as $url) {
            ProductImage::create([
                'product_id' => 14,
                'image_url' => $url,
                'alt_text' => $url,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $urls7 = [
            'hop-qua-tet-cao-cap-tam-phuc-tra-viet-1.jpg',
            'hop-qua-tet-cao-cap-tam-phuc-tra-viet-2.jpg',
            'hop-qua-tet-cao-cap-tam-phuc-tra-viet-3.jpg',
            'hop-qua-tet-cao-cap-tam-phuc-tra-viet-4.jpg',
        ];
        foreach ($urls7 as $url) {
            ProductImage::create([
                'product_id' => 21,
                'image_url' => $url,
                'alt_text' => $url,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
