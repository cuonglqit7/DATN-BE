# Laravel Project

## Giới thiệu

Dự án này là một ứng dụng web được xây dựng bằng Laravel, một framework PHP mạnh mẽ để phát triển ứng dụng web hiện đại.

## Yêu cầu hệ thống

-   PHP >= 8.2
-   Composer
-   MySQL
-   Node.js & npm

## Cài đặt

### 1. Clone repository

```bash
git clone https://github.com/cuonglqit7/laravel11_ecommerce.git
cd your-repo
```

### 2. Cài đặt dependencies

```bash
composer install
```

### 3. Cấu hình môi trường

Tạo file `.env` từ `.env.example`:

```bash
cp .env.example .env
```

Chỉnh sửa file `.env` để phù hợp với cấu hình database của bạn.

### 4. Tạo khóa ứng dụng

```bash
php artisan key:generate
```

### 5. Thiết lập cơ sở dữ liệu

```bash
php artisan migrate --seed
```

### 6. Cài đặt dependencies frontend (nếu có)

```bash
npm install && npm run dev
```

## Chạy ứng dụng

Khởi động server Laravel:

```bash
php artisan serve
```

Ứng dụng sẽ chạy tại: `http://127.0.0.1:8000`

## Cấu trúc thư mục chính

```
├── app/           # Code backend chính
├── bootstrap/     # Bootstrap ứng dụng
├── config/        # Các file cấu hình
├── database/      # Migration, Seeder
├── public/        # Thư mục chứa tài nguyên công khai
├── resources/     # View, CSS, JS
├── routes/        # Định tuyến
├── storage/       # Lưu trữ file, cache, logs
├── tests/         # Unit tests
└── vendor/        # Dependencies của Laravel
```

## Lệnh Artisan hữu ích

```bash
php artisan migrate:fresh --seed    # Reset database và seed lại dữ liệu
php artisan route:list              # Hiển thị danh sách route
php artisan cache:clear             # Xóa cache ứng dụng
php artisan config:clear            # Xóa cache config
php artisan make:model ModelName -m # Tạo Model kèm Migration
```

## Một số cấu hình khác

## Cloudiary

-   Cloud name space: @dry0a5i63
-   Upload preset name: qzngfupm

## Permissions

Quản lý các quyền của user

## laravel-sluggable

Class Eloquent handler sluggable

## Đóng góp

Mọi đóng góp đều được hoan nghênh! Vui lòng fork repository và gửi pull request.

## Giấy phép

Dự án này sử dụng giấy phép MIT. Xem file `LICENSE` để biết thêm chi tiết.
