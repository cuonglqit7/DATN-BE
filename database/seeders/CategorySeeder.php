<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['Trà', 'Sản phẩm về trà'],
            ['Bộ Ấm Trà', 'Sản phẩm về trà cụ'],
            ['Hạt', 'Sản phẩm về hạt'],
            ['Quà tặng', 'Sản phẩm về quà tặng'],
            ['Bánh', 'Sản phẩm về bánh'],
            ['Quà tết', 'Sản phẩm về quà tết'],
        ];

        foreach ($categories as $index => $category) {
            Category::create([
                'category_name' => $category[0],
                'slug' => Str::slug($category[0]),
                'position' => $index + 1,
                'description' => $category[1],
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
