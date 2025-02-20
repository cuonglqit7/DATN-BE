<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());

        $categories = Category::query()
            ->when($request->category_name, function ($query) use ($request) {
                $query->where('category_name', 'like', '%' . $request->category_name . '%');
            })
            ->orderBy('position', 'ASC')
            ->get();
        return view('categories.index', compact('categories'));
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
        $sub_categories = Category::query()
            ->when($request->category_name, function ($query) use ($request) {
                $query->where('category_name', 'like', '%' . $request->category_name . '%');
            })
            ->where('parent_id', '=', $category->id)
            ->orderBy('position', 'ASC')
            ->get();
        return view('categories.show', compact('sub_categories', 'category'));
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
    public function destroy(string $id)
    {
        //
    }
}
