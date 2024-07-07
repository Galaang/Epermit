<?php

namespace Database\Seeders;

use App\Models\pangkat_jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pangkat_jabatan_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        pangkat_jabatan::create([
            'name' => 'Penata Tingkat 1'
        ]);
        pangkat_jabatan::create([
            'name' => 'Penata Muda Tingkat 1'
        ]);
        pangkat_jabatan::create([
            'name' => 'Penata'
        ]);
        pangkat_jabatan::create([
            'name' => 'Pengatur Tingkat 1'
        ]);
        pangkat_jabatan::create([
            'name' => 'Pengatur'
        ]);
    }
}
