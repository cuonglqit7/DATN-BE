<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticlesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('articles')->insert([
            [
                'title' => 'Bí quyết thành công trong lập trình web',
                'slug' => Str::slug('Bí quyết thành công trong lập trình web'),
                'thumbnail_url' => 'https://example.com/images/web-development.jpg',
                'content' => 'Lập trình web đòi hỏi sự kiên nhẫn, thực hành liên tục và cập nhật công nghệ mới...',
                'short_description' => 'Hướng dẫn cách để trở thành một lập trình viên web giỏi.',
                'article_category_id' => 1,
                'user_id' => 1,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Những xu hướng công nghệ năm 2025',
                'slug' => Str::slug('Những xu hướng công nghệ năm 2025'),
                'thumnail_url' => 'https://example.com/images/tech-trends.jpg',
                'content' => 'Năm 2025, công nghệ AI, blockchain, và điện toán đám mây sẽ tiếp tục phát triển mạnh mẽ...',
                'short_description' => 'Khám phá các công nghệ đột phá sẽ thay đổi thế giới.',
                'article_category_id' => 2,
                'user_id' => 1,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Cách viết nội dung chuẩn SEO',
                'slug' => Str::slug('Cách viết nội dung chuẩn SEO'),
                'thumnail_url' => 'https://example.com/images/seo-content.jpg',
                'content' => 'SEO là một yếu tố quan trọng giúp bài viết tiếp cận đúng đối tượng...',
                'short_description' => 'Hướng dẫn cách viết bài chuẩn SEO để tăng thứ hạng trên Google.',
                'article_category_id' => 3,
                'user_id' => 1,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
