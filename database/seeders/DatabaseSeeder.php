<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Pest\Laravel\call;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin@gmail.com'
        ]);

        $this->call(PermissionSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductImageSeeder::class);
        $this->call(ProductReviewsSeeder::class);
        $this->call(DiscountsSeeder::class);
        $this->call(ArticleCategoriesSeeder::class);
        $this->call(ArticlesSeeder::class);
        $this->call(ProductAttributesSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
