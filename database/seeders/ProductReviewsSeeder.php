<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductReview;
use Illuminate\Support\Carbon;

class ProductReviewsSeeder extends Seeder
{
    public function run(): void
    {
        for ($productId = 1; $productId <= 30; $productId++) {
            for ($i = 1; $i <= 3; $i++) {
                ProductReview::create([
                    'product_id' => $productId,
                    'user_id' => 1,
                    'rating' => rand(1, 5),
                    'comment' => 'This is a sample review for product ' . $productId,
                    'status' => true,
                    'created_at' => Carbon::now()->subDays(rand(0, 30)),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
