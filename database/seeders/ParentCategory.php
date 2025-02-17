<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ParentCategory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parentCategories = [
            'Trà Xanh',
            'Trà Đen',
            'Trà Thảo Mộc',
            'Trà Ô Long',
            'Trà Đặc Biệt'
        ];

        foreach ($parentCategories as $index => $category) {
            DB::table('parent_categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'position' => $index + 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
