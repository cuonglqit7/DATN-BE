<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $numperpage = $request->record_number ?? 5;

        $articles = Article::query()
            ->when($request->name, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->name . '%');
            })
            ->paginate($numperpage);

        return view('articles.index', compact('articles', 'numperpage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articleCategoires = ArticleCategory::orderBy('name', 'asc')->get();
        $products = Product::orderBy('id', 'desc')->get();
        return view('articles.create', compact('products', 'articleCategoires'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'thumbnail' => 'required|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'selected_product' => 'nullable|exists:products,id',
            'status' => 'boolean',
            'articleCategories' => 'required|exists:article_categories,id',
        ], [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'boolean' => ':attribute phải là đúng hoặc sai.',
            'exists' => ':attribute không hợp lệ.',
        ], [
            'title' => 'Tiêu đề',
            'thumbnail' => 'Ảnh đại diện',
            'short_description' => 'Mô tả ngắn',
            'content' => 'Nội dung',
            'selected_product' => 'Sản phẩm liên kết',
            'status' => 'Trạng thái',
            'articleCategories' => 'Danh mục bài viết',
        ]);


        $image = $request->file('thumbnail');
        $path = $image->store('articles/thumbnail', 'public');

        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'thumbnail_url' => $path,
            'short_description' => $request->short_description,
            'content' => $request->content,
            'product_id' => $request->selected_product,
            'user_id' => auth()->user()->id,
            'status' => $request->status,
            'article_category_id' => $request->articleCategories,
        ]);

        return redirect()->route('articles.index')->with('success', 'Bài viết đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::find($id);
        $articleCategoires = ArticleCategory::orderBy('name', 'asc')->get();
        $products = Product::orderBy('id', 'desc')->get();
        return view('articles.edit', compact('article', 'products', 'articleCategoires'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'thumbnail' => 'nullable|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'selected_product' => 'nullable|exists:products,id',
            'status' => 'boolean',
            'articleCategories' => 'required|exists:article_categories,id',
        ], [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'boolean' => ':attribute phải là đúng hoặc sai.',
            'exists' => ':attribute không hợp lệ.',
        ], [
            'title' => 'Tiêu đề',
            'thumbnail' => 'Ảnh đại diện',
            'short_description' => 'Mô tả ngắn',
            'content' => 'Nội dung',
            'selected_product' => 'Sản phẩm liên kết',
            'status' => 'Trạng thái',
            'articleCategories' => 'Danh mục bài viết',
        ]);


        $article = Article::find($id);

        if ($request->hasFile('thumbnail')) {
            // Xóa hình cũ nếu tồn tại
            if (!empty($article->thumbnail_url)) {
                Storage::disk('public')->delete($article->thumbnail_url);
            }

            // Lưu hình mới
            $image = $request->file('thumbnail');
            $path = $image->store('articles/thumbnail', 'public');

            $article->thumbnail_url = $path;
        }

        $article->title = $request->title;
        $article->slug = Str::slug($request->title);
        $article->short_description = $request->short_description;
        $article->content = $request->content;
        $article->product_id = $request->selected_product;
        $article->status = $request->status;
        $article->user_id = auth()->user()->id;
        $article->article_category_id = $request->articleCategories;
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Bài viết đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function toggleStatus(string $id)
    {
        $article = Article::find($id);
        $article->status = !$article->status;
        $article->save();
        return redirect()->back()->with('success', 'Trạng thái bài viết đã được cập nhật!');
    }

    public function toggleOn(Request $request)
    {
        $ids = explode(',', $request->article_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một bài viết.');
        }

        Article::whereIn('id', $ids)->update([$request->fields => true]);

        return redirect()->back()->with('success', 'Đã cập nhật các bài viết đã chọn.');
    }

    public function toggleOff(Request $request)
    {
        // dd($request->all());
        $ids = explode(',', $request->article_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một bài viết.');
        }

        Article::whereIn('id', $ids)->update([$request->fields => false]);

        return redirect()->back()->with('success', 'Đã cập nhật các bài viết đã chọn.');
    }
}
