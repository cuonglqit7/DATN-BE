@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-8 border rounded shadow">
        <h2 class="text-2xl font-bold text-center">Đăng Ký</h2>

        @if ($errors->any())
            <p class="text-red-500 text-center">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mt-4">
                <label class="block">Tên</label>
                <input type="text" name="name" class="w-full p-2 border rounded" required>
            </div>
            <div class="mt-4">
                <label class="block">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded" required>
            </div>
            <div class="mt-4">
                <label class="block">Mật khẩu</label>
                <input type="password" name="password" class="w-full p-2 border rounded" required>
            </div>
            <div class="mt-4">
                <label class="block">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="w-full p-2 border rounded" required>
            </div>
            <div class="mt-4">
                <button class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">Đăng Ký</button>
            </div>
        </form>
    </div>
@endsection
