<?php

namespace Database\Seeders;

use App\Models\jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class jabatan_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        jabatan::create([
            'name' => 'Dosen',
        ]);
        jabatan::create([
            'name' => 'Ketua Prodi',
        ]);
        jabatan::create([
            'name' => 'Ketua Jurusan',
        ]);
        jabatan::create([
            'name' => 'Wakil Direktur 1',
        ]);
        jabatan::create([
            'name' => 'Wakil Direktur 2',
        ]);
        jabatan::create([
            'name' => 'Baup',
        ]);
    }
}
