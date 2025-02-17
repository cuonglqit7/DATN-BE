<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Lipton',
            'Dilmah',
            'Twinings',
            'Tân Cương Xanh',
            'Vinatea',
            'Oolong Tea House',
            'Hùng Phát',
            'Phúc Long',
            'Tea Plus',
            'Chin-Su'
        ];

        foreach ($brands as $index => $brand) {
            DB::table('brands')->insert([
                'name' => $brand,
                'slug' => Str::slug($brand),
                'logo' => null,
                'description' => 'Thương hiệu trà nổi tiếng với nhiều loại trà chất lượng.',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
