<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        foreach ($request->images as $image) {
            $path = $image->store('products', 'public');
            ProductImage::create([
                'product_id' => $request->product_id,
                'image_url' => $path,
                'alt_text' => $path,
            ]);
        }

        return redirect()->back();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function isPrimary(string $id)
    {
        $productImage = ProductImage::find($id);

        $productImages = ProductImage::where('product_id', $productImage->product_id)->get();
        foreach ($productImages as $image) {
            $image->is_primary = false;
            $image->save();
        }
        $productImage->is_primary = !$productImage->is_primary;
        $productImage->save();

        return back()->with('success', 'Hình chính sản phẩm đã được cập nhật!');
    }
}
