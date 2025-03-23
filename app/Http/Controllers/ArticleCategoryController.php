<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $numperpage = $request->record_number ?? 10;

        $articleCategories = ArticleCategory::query()
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->withCount('articles')
            ->orderBy('position', 'ASC')
            ->paginate($numperpage);

        return view('articleCategories.index', compact('articleCategories', 'numperpage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articleCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'position' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        // Lấy số thứ tự cao nhất nếu không có position
        $maxPosition = ArticleCategory::max('position');
        $position = $request->position ?? ($maxPosition + 1);

        // Nếu position đã tồn tại, đẩy các danh mục khác xuống 1 bậc
        ArticleCategory::where('position', '>=', $position)->increment('position');

        // Tạo danh mục mới
        ArticleCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'position' => $position,
            'description' => $request->description,
            'status' => $request->status ?? false,
        ]);

        return redirect()->route('articleCategories.index')->with('success', 'Danh mục đã được thêm!');
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
    public function edit(ArticleCategory $articleCategory)
    {
        return view('articleCategories.edit', compact('articleCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticleCategory $articleCategory)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'position' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        // Lấy vị trí hiện tại của danh mục
        $oldPosition = $articleCategory->position;
        $newPosition = $request->position ?? $oldPosition;

        // Nếu vị trí thay đổi, cập nhật lại vị trí
        if ($newPosition != $oldPosition) {
            // Nếu vị trí mới nhỏ hơn vị trí cũ, đẩy các danh mục giữa lên 1 bậc
            if ($newPosition < $oldPosition) {
                ArticleCategory::whereBetween('position', [$newPosition, $oldPosition - 1])
                    ->increment('position');
            }
            // Nếu vị trí mới lớn hơn vị trí cũ, đẩy các danh mục giữa xuống 1 bậc
            else {
                ArticleCategory::whereBetween('position', [$oldPosition + 1, $newPosition])
                    ->decrement('position');
            }
        }

        // Cập nhật danh mục
        $articleCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'position' => $newPosition,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('articleCategories.index')->with('success', 'Danh mục đã được cập nhật!');
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
        $articleCategories = ArticleCategory::find($id);
        $articleCategories->status = !$articleCategories->status;
        $articleCategories->save();
        return back()->with('success', 'Trạng thái danh mục bài viết đã được cập nhật!');
    }

    public function toggleOn(Request $request)
    {
        $ids = explode(',', $request->articleCategory_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một danh mục.');
        }

        ArticleCategory::whereIn('id', $ids)->update([$request->fields => true]);

        return redirect()->back()->with('success', 'Đã cập nhật các danh mục đã chọn.');
    }

    public function toggleOff(Request $request)
    {
        // dd($request->all());
        $ids = explode(',', $request->articleCategory_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một danh mục.');
        }

        ArticleCategory::whereIn('id', $ids)->update([$request->fields => false]);

        return redirect()->back()->with('success', 'Đã cập nhật các danh mục đã chọn.');
    }

    public function updatePosition(Request $request, string $id)
    {
        $category = ArticleCategory::findOrFail($id);
        $newPosition = $request->position;
        $oldPosition = $category->position;

        if ($newPosition == $oldPosition) {
            return back()->with('success', 'Không có thay đổi vị trí!');
        }

        if ($newPosition > $oldPosition) {
            ArticleCategory::whereBetween('position', [$oldPosition + 1, $newPosition])
                ->decrement('position');
        } else {
            ArticleCategory::whereBetween('position', [$newPosition, $oldPosition - 1])
                ->increment('position');
        }

        $category->position = $newPosition;
        $category->save();

        return back()->with('success', 'Cập nhật vị trí thành công!');
    }
}
