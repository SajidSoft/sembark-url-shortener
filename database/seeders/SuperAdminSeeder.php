<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'superadmin@sembark.com'],
            [
                'name' => 'System SuperAdmin',
                'password' => Hash::make('password'),
                'role' => UserRole::SUPER_ADMIN->value,
                'company_id' => null,
                'email_verified_at' => now(),
            ]
        );
    }
}
