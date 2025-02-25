<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            "role-list",
            "role-create",
            "role-edit",
            "role-delete",
            "product-list",
            "product-create",
            "product-edit",
            "product-delete",
            "user-list",
            "user-create",
            "user-edit",
            "user-delete",
            "category-list",
            "category-create",
            "category-edit",
            "category-delete",
            "discount-list",
            "discount-create",
            "discount-edit",
            "discount-delete",
            "post-list",
            "post-create",
            "post-edit",
            "post-delete",
            "order-list",
            "order-edit",
            "order-delete",
            "article-list",
            "article-create",
            "article-edit",
            "article-delete"
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        $adminRole->syncPermissions(Permission::all());

        $managerRole->syncPermissions([
            "role-list",
            "role-create",
            "role-edit",
            "product-list",
            "product-create",
            "product-edit",
            "category-list",
            "category-create",
            "category-edit",
            "discount-list",
            "discount-create",
            "discount-edit",
            "post-list",
            "post-create",
            "post-edit",
            "order-list",
            "order-edit",
            "article-list",
            "article-create",
            "article-edit",
        ]);

        $adminUser = User::first();
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }
    }
}
