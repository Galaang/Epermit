<?php

namespace Database\Seeders;

use App\Models\role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class role_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        role::create([
            'name' => 'Karyawan',
        ]);
        role::create([
            'name' => 'Kepala Bagian',
        ]);
        role::create([
            'name' => 'Wadir2',
        ]);
        role::create([
            'name' => 'Bagian Umum',
        ]);

    }
}
