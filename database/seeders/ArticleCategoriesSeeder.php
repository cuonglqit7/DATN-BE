<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArticleCategory;

class ArticleCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Trà Truyền Thống', 'status' => true],
            ['name' => 'Trà Thảo Mộc', 'status' => true],
            ['name' => 'Phụ Kiện Pha Trà', 'status' => true],
            ['name' => 'Quà Tặng Trà Cao Cấp', 'status' => true],
            ['name' => 'Bí Quyết Thưởng Trà', 'status' => true],
        ];

        foreach ($categories as $category) {
            ArticleCategory::create($category);
        }
    }
}
