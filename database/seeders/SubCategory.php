<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubCategory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [
            ['Trà Xanh Thái Nguyên', 'Trà Xanh'],
            ['Trà Đen Ceylon', 'Trà Đen'],
            ['Trà Atiso', 'Trà Thảo Mộc'],
            ['Trà Ô Long Đài Loan', 'Trà Ô Long'],
            ['Trà Sen Tây Hồ', 'Trà Đặc Biệt']
        ];

        foreach ($subCategories as $index => $subCategory) {
            $parentCategoryId = DB::table('parent_categories')->where('name', $subCategory[1])->value('id');

            DB::table('sub_categories')->insert([
                'name' => $subCategory[0],
                'slug' => Str::slug($subCategory[0]),
                'position' => $index + 1,
                'status' => 'active',
                'parent_category_id' => $parentCategoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
