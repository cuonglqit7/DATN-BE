<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $numperpage = $request->record_number ?? 5;
        $users = User::query()
            ->when($request->email, function ($query) use ($request) {
                $query->where('email', 'like', '%' . $request->email . '%');
            })
            ->withCount(['orders' => function ($query) {
                $query->where('status', 'Completed');
            }])
            ->role('user')
            ->orderBy('id', 'DESC')
            ->paginate($numperpage);

        return view('users.index', compact('users', 'numperpage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'password' => 'required',
        //     'repeat_password' => 'required|same:password'
        // ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password)
        // ]);

        // $user->syncRoles($request->roles);

        // return redirect()->route('users.index')->with('success', 'Người dùng đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $user = User::find($id);
        // $roles = Role::all();
        // return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'password' => 'required',
        //     'repeat_password' => 'required|same:password'
        // ]);

        // $user = User::find($id);

        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password =  Hash::make($request->password);
        // $user->save();
        // $user->syncRoles($request->roles);
        // return redirect()->route('users.index')->with('success', 'Người dùng đã được chỉnh sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa thành công!');
    }

    public function toggleStatus($id)
    {
        $user = User::find($id);
        $user->status = !$user->status;
        $user->save();
        return back()->with('success', 'Trạng thái người dùng đã được cập nhật!');
    }

    public function toggleOn(Request $request)
    {
        $ids = explode(',', $request->user_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một bài viết.');
        }

        User::whereIn('id', $ids)->update([$request->fields => true]);

        return redirect()->back()->with('success', 'Đã cập nhật các bài viết đã chọn.');
    }

    public function toggleOff(Request $request)
    {
        // dd($request->all());
        $ids = explode(',', $request->user_ids);

        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một bài viết.');
        }

        User::whereIn('id', $ids)->update([$request->fields => false]);

        return redirect()->back()->with('success', 'Đã cập nhật các bài viết đã chọn.');
    }
}
