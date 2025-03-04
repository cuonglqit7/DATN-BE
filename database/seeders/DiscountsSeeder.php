<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DiscountsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('discounts')->insert([
            [
                'code' => 'SALE10',
                'discount_type' => 'Percentage',
                'discount_value' => 10.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'WELCOME50',
                'discount_type' => 'Fixed Amount',
                'discount_value' => 50.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(15),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'FREESHIP',
                'discount_type' => 'Fixed Amount',
                'discount_value' => 20.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
