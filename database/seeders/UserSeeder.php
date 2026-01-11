<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    // Admin LAA
    User::updateOrCreate(
      ['email' => 'laa@test.com'],
      [
        'name' => 'Admin LAA',
        'nim' => null,
        'role' => 'LAA',
        'is_active' => true,
        'force_change_password' => false,
        'password' => Hash::make('password'),
      ]
    );

    // Pengawas (login pakai NIM)
    User::updateOrCreate(
      ['nim' => '1301210001'],
      [
        'name' => 'Ahmad Fauzi',
        'email' => 'ahmad@telu.ac.id',
        'role' => 'PENGAWAS',
        'is_active' => true,
        'force_change_password' => true,
        'password' => Hash::make('password123'),
      ]
    );
  }
}
