<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin      = Role::create(['name' => 'admin']);
        $staff      = Role::create(['name' => 'staff']);

        // Buat user Super Admin
        $userSuperAdmin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@mail.com',
            'password' => Hash::make('password'),
        ]);
        $userSuperAdmin->assignRole($superAdmin);

        // Buat user Admin
        $userAdmin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@mail.com',
            'password' => Hash::make('password'),
        ]);
        $userAdmin->assignRole($admin);

        // Buat user Staff
        $userStaff = User::create([
            'name'     => 'Staff',
            'email'    => 'staff@mail.com',
            'password' => Hash::make('password'),
        ]);
        $userStaff->assignRole($staff);
    }
}