<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $numperpage = $request->record_number ?? 10;
        $banners = Banner::orderBy('position')->paginate($numperpage);
        return view('banners.index', compact('banners', 'numperpage'));
    }

    public function create()
    {
        return view('banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_url' => 'required|image|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'position' => 'required|integer',
            'status' => 'boolean'
        ]);

        $existingBanner = Banner::where('position', $request->position)->first();

        if ($existingBanner) {
            Banner::where('position', '>=', $request->position)
                ->increment('position');
        }

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('banners', 'public');
        }

        Banner::create([
            'image_url' => $path,
            'alt_text' => $request->alt_text,
            'link' => $request->link,
            'position' => $request->position,
            'status' => $request->has('status') ? true : false
        ]);

        return redirect()->route('banners.index')
            ->with('success', 'Banner đã được tạo thành công');
    }


    public function edit(Banner $banner)
    {
        return view('banners.edit', compact('banner'));
    }

    // Cập nhật banner
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image_url' => 'nullable|image|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'position' => 'required|integer',
            'status' => 'boolean'
        ]);

        // Kiểm tra xem vị trí mới có trùng với banner khác không
        $existingBanner = Banner::where('position', $request->position)->first();

        // Nếu vị trí đã có banner, xử lý thay đổi vị trí
        if ($existingBanner && $existingBanner->id != $banner->id) {
            // Cập nhật tất cả các banner có vị trí >= vị trí mới, tăng lên 1
            Banner::where('position', '>=', $request->position)
                ->increment('position');
        }

        // Cập nhật dữ liệu banner
        $data = $request->only(['alt_text', 'link', 'position']);
        $data['status'] = $request->has('status') ? true : false;

        // Nếu có thay đổi ảnh, xóa ảnh cũ và lưu ảnh mới
        if ($request->hasFile('image_url')) {
            if ($banner->image_url) {
                Storage::disk('public')->delete($banner->image_url);
            }
            $data['image_url'] = $request->file('image_url')->store('banners', 'public');
        }

        // Cập nhật banner với dữ liệu mới
        $banner->update($data);

        return redirect()->route('banners.index')
            ->with('success', 'Banner đã được cập nhật thành công');
    }


    public function destroy(Banner $banner)
    {
        if ($banner->image_url) {
            Storage::disk('public')->delete($banner->image_url);
        }

        $banner->delete();

        return redirect()->route('banners.index')
            ->with('success', 'Banner đã được xóa thành công');
    }

    // Thay đổi trạng thái banner (active/inactive)
    public function toggleStatus(Banner $banner)
    {
        $banner->update([
            'status' => !$banner->status
        ]);

        return redirect()->route('banners.index')
            ->with('success', 'Trạng thái banner đã được cập nhật');
    }

    public function updatePosition(Request $request, string $id)
    {
        $category = Banner::findOrFail($id);
        $newPosition = $request->position;
        $oldPosition = $category->position;

        if ($newPosition == $oldPosition) {
            return back()->with('success', 'Không có thay đổi vị trí!');
        }

        if ($newPosition > $oldPosition) {
            Banner::whereBetween('position', [$oldPosition + 1, $newPosition])
                ->decrement('position');
        } else {
            Banner::whereBetween('position', [$newPosition, $oldPosition - 1])
                ->increment('position');
        }

        $category->position = $newPosition;
        $category->save();

        return back()->with('success', 'Cập nhật vị trí thành công!');
    }

    public function toggleOn(Request $request)
    {
        $ids = explode(',', $request->banners_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một danh mục.');
        }

        Banner::whereIn('id', $ids)->update([$request->fields => true]);

        return redirect()->back()->with('success', 'Đã cập nhật các danh mục đã chọn.');
    }

    public function toggleOff(Request $request)
    {
        $ids = explode(',', $request->banners_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một danh mục.');
        }

        Banner::whereIn('id', $ids)->update([$request->fields => false]);

        return redirect()->back()->with('success', 'Đã cập nhật các danh mục đã chọn.');
    }
}
