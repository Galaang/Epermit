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
            'name' => 'Teknik Informatika'
        ]);

        Unit_kerja::create([
            'name' => 'Teknik Elektro'
        ]);

        Unit_kerja::create([
            'name' => 'Teknik Mesin'
        ]);
        Unit_kerja::create([
            'name' => 'Teknik Listrik'
        ]);
        Unit_kerja::create([
            'name' => 'Pengembangan Produk Agroindustri'
        ]);
    }
}
