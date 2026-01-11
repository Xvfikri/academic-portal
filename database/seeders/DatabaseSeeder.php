<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Prodi;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeding Prodi
        $prodis = [
            'S1 Teknik Industri',
            'S1 Sistem Informasi',
            'S1 Teknik Informatika',
            'S1 Teknik Logistik',
            'S1 Manajemen Rekayasa',
        ];

        foreach ($prodis as $p) {
            Prodi::create(['name' => $p]);
        }

        // Seeding LAA User
        User::create([
            'name' => 'Admin LAA',
            'nip' => '12345678',
            'email' => 'admin@telu.ac.id',
            'password' => Hash::make('password'),
            'role' => 'LAA',
            'status' => 'AKTIF',
        ]);

        // Seeding a Pengawas User
        $ifProdi = Prodi::where('name', 'S1 Teknik Informatika')->first();
        User::create([
            'name' => 'Dr. Ahmad Fauzi',
            'nip' => '1301210001',
            'email' => 'ahmad@telu.ac.id',
            'password' => Hash::make('password'),
            'role' => 'PENGAWAS',
            'status' => 'AKTIF',
            'prodi_id' => $ifProdi->id,
        ]);
    }
}
