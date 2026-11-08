<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $roles = [
            'Super Admin',
        ];
        collect($roles)
            ->map(fn ($role) => ['name' => $role, 'guard_name' => 'web', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()])
            ->pipe(fn ($roles) => Role::query()->insertOrIgnore($roles->toArray()));

        $permissions = [
            'user_management_view',
            'user_management_edit',
            'user_management_create',
            'user_management_delete',
            'user_password_reset',

            'role_view',
            'role_edit',
            'role_create',
            'role_delete',
        ];

        collect($permissions)
            ->map(fn ($permission) => ['name' => $permission, 'guard_name' => 'web', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()])
            ->map(fn($permission) => Permission::query()->updateOrCreate(['name' => $permission['name']], $permission));
    }
}
