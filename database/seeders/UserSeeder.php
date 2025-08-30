<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // Impor kelas Role dari Spatie

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pastikan peran 'owner' dan 'admin' ada
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // 2. Buat atau update pengguna Owner (Super Admin)
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('SecretDev123!'),
            ]
        );

        // 3. Berikan peran 'owner' kepada pengguna Super Admin
        $superAdmin->assignRole($ownerRole);

        // 4. Buat atau update Admin Staff
        $adminStaff = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin Staff',
                'password' => Hash::make('SecretDev123!'),
            ]
        );

        // 5. Berikan peran 'admin' kepada pengguna Admin Staff
        $adminStaff->assignRole($adminRole);
    }
}
