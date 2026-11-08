<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'mahmudur.rashid26@gmail.com')->first();
        if(!$user) {
            $user = User::query()->create([
                'name' => 'Super Admin',
                'email' => 'mahmudur.rashid26@gmail.com',
                'password' => bcrypt('mahmudur.rashid26@gmail.com'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $role = Role::query()->first();
        $role->syncPermissions(Permission::query()->where('guard_name', 'web')->get());

        $user->syncRoles($role);
    }
}
