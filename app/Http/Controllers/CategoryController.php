<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:category-create|category-list|category-edit|category-delete'], ['only' => ['index']]);
        $this->middleware(['permission:category-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:category-edit'], ['only' => ['edit', 'update', 'toggleStatus']]);
        $this->middleware(['permission:category-delete'], ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $numperpage = $request->record_number ?? 10;
        $categories = Category::query()
            ->when($request->category_name, function ($query) use ($request) {
                $query->where('category_name', 'like', '%' . $request->category_name . '%');
            })
            ->whereNotNull('position')
            ->withCount('products')
            ->orderBy('position', 'ASC')
            ->paginate($numperpage);

        return view('categories.index', compact('categories', 'numperpage'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('position', 'ASC')->get();
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'category_name' => 'required|max:50',
        ], [
            'category_name.required' => 'Tên danh mục không được để trống.',
            'category_name.max' => 'Tên danh mục không được vượt quá 50 ký tự.',
        ]);


        //tăng vị trí của các position từ position chỉ định
        if (!$request->parent_id) {
            Category::where('position', '>=', $request->position)
                ->increment('position', 1);
            $position = $request->position;
        } else {
            $position = null;
        }


        $slug = Str::slug($request->category_name);
        Category::create([
            'category_name' => $request->category_name,
            'slug' => $slug,
            'description' => $request->description ?? null,
            'position' => $position,
            'parent_id' => $request->parent_id ?? null,
        ]);

        return redirect()->route('categories.index')->with('success', 'Đã thêm danh mục thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Category $category)
    {
        $numperpage = $request->record_number ?? 10;
        $sub_categories = Category::query()
            ->when($request->category_name, function ($query) use ($request) {
                $query->where('category_name', 'like', '%' . $request->category_name . '%');
            })
            ->where('parent_id', '=', $category->id)
            ->orderBy('position', 'ASC')
            ->get();
        return view('categories.show', compact('sub_categories', 'category', 'numperpage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|max:50',
        ], [
            'category_name.required' => 'Tên danh mục không được để trống.',
            'category_name.max' => 'Tên danh mục không được vượt quá 50 ký tự.',
        ]);


        //tăng vị trí của các position từ position chỉ định
        if (!$request->parent_id) {
            Category::where('position', '>=', $request->position)
                ->increment('position', 1);
            $position = $request->position;
        } else {
            $position = null;
        }

        $slug = Str::slug($request->category_name);

        $category->update([
            'category_name' => $request->category_name,
            'slug' => $slug,
            'description' => $request->description ?? null,
            'position' => $position,
            'parent_id' => $request->parent_id ?? null,
        ]);

        return redirect()->route('categories.index')->with('success', 'Đã chỉnh sửa danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $isProduct = Product::where('category_id', $category->id)->first();

        if ($isProduct) {
            return back()->with('error', 'Danh mục không được xóa do có nhiều sản phẩm liên quan!');
        }
        $category->delete();
        return back()->with('success', 'Danh mục đã được xóa thành công!');
    }

    public function toggleStatus($id)
    {
        $category = Category::find($id);
        $category->status = !$category->status;
        $category->save();
        return back()->with('success', 'Trạng thái danh mục đã được cập nhật!');
    }

    public function toggleOn(Request $request)
    {
        $ids = explode(',', $request->categories_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một danh mục.');
        }

        Category::whereIn('id', $ids)->update([$request->fields => true]);

        return redirect()->back()->with('success', 'Đã cập nhật các danh mục đã chọn.');
    }

    public function toggleOff(Request $request)
    {
        // dd($request->all());
        $ids = explode(',', $request->categories_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một danh mục.');
        }

        Category::whereIn('id', $ids)->update([$request->fields => false]);

        return redirect()->back()->with('success', 'Đã cập nhật các danh mục đã chọn.');
    }

    public function updatePosition(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $newPosition = $request->position;
        $oldPosition = $category->position;

        if ($newPosition == $oldPosition) {
            return back()->with('success', 'Không có thay đổi vị trí!');
        }

        if ($newPosition > $oldPosition) {
            Category::whereBetween('position', [$oldPosition + 1, $newPosition])
                ->decrement('position');
        } else {
            Category::whereBetween('position', [$newPosition, $oldPosition - 1])
                ->increment('position');
        }

        $category->position = $newPosition;
        $category->save();

        return back()->with('success', 'Cập nhật vị trí thành công!');
    }
}
