<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArticleCategory;

class ArticleCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Trà Truyền Thống',
                'slug' => 'tra-truyen-thong',
                'position' => 1,
                'status' => true
            ],
            [
                'name' => 'Trà Thảo Mộc',
                'slug'  => 'tra-thao-moc',
                'position' => 2,
                'status' => true
            ],
            [
                'name' => 'Phụ Kiện Pha Trà',
                'slug' => 'phu-kien-pha-tra',
                'position' => 3,
                'status' => true
            ],
            [
                'name' => 'Quà Tặng Trà Cao Cấp',
                'slug' => 'qua-tang-tra-cao-cap',
                'position' => 4,
                'status' => true
            ],
            [
                'name' => 'Bí Quyết Thưởng Trà',
                'slug' => 'bi-quyet-thuong-tra',
                'position' => 5,
                'status' => true
            ],
        ];

        foreach ($categories as $category) {
            ArticleCategory::create($category);
        }
    }
}
