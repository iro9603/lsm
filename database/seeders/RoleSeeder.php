<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructor = Role::create([
            'name' => 'instructor'
        ]);

        $instructor->syncPermissions([
            'manage_courses'
        ]);

        $admin = Role::create([
            'name' => 'admin'
        ]);

        $admin->syncPermissions([
            'access_dashboard',
            'manage_users',
            'manage_roles',
            'manage_permissions'
        ]);

        $user = User::find(1);
        $user->syncRoles([
            'admin',
            'instructor'
        ]);
    }
}
