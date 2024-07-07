<?php

namespace Database\Seeders;

use App\Models\Unit_kerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class unit_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit_kerja::create([
            'name' => 'Direksi'
        ]);
        Unit_kerja::create([
            'name' => 'P4MP'
        ]);
        Unit_kerja::create([
            'name' => 'PPPM'
        ]);
        Unit_kerja::create([
            'name' => 'Teknik Elektronika'
        ]);
        Unit_kerja::create([
            'name' => 'Teknik Mesin'
        ]);
        Unit_kerja::create([
            'name' => 'Pengembangan Produk Agroindustri'
        ]);
        Unit_kerja::create([
            'name' => 'Teknik Pengendalian Pencemaran Lingkungan'
        ]);
        Unit_kerja::create([
            'name' => 'Teknik Informatika'
        ]);
        Unit_kerja::create([
            'name' => 'Akuntasi Lembaga Keungan Syariah'
        ]);
        Unit_kerja::create([
            'name' => 'Subbagian Umum'
        ]);
        Unit_kerja::create([
            'name' => 'Teknik Informatika'
        ]);
        Unit_kerja::create([
            'name' => 'Akademik'
        ]);
        Unit_kerja::create([
            'name' => 'Keuangan'
        ]);
        Unit_kerja::create([
            'name' => 'TIK'
        ]);
        Unit_kerja::create([
            'name' => 'UP3'
        ]);
        Unit_kerja::create([
            'name' => 'Bahasa'
        ]);
        Unit_kerja::create([
            'name' => 'Perpustakaan'
        ]);
    }
}
