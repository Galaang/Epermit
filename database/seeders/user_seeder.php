<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class user_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'role_id' => 1,
        //     'nip' => '12345',
        //     'name' => 'Galang',
        //     'pangkat_jabatan_id' => 1,
        //     'jabatan_id' => 1,
        //     'unit_id' => 1,
        //     'password' => bcrypt('12345'),
        // ]);

        // User::create([
        //     'role_id' => 2,
        //     'nip' => '11111',
        //     'name' => 'Willy',
        //     'pangkat_jabatan_id' => 1,
        //     'jabatan_id' => 1,
        //     'unit_id' => 1,
        //     'password' => bcrypt('11111'),
        // ]);

        // User::create([
        //     'role_id' => 3,
        //     'nip' => '22222',
        //     'name' => 'Ikmal',
        //     'pangkat_jabatan_id' => 1,
        //     'jabatan_id' => 1,
        //     'unit_id' => 1,
        //     'password' => bcrypt('22222'),
        // ]);
        User::create([
            'role_id' => 4,
            'nip' => '199009202019032019',
            'name' => 'Windi Astriani, A.Md.',
            'email' => 'baup@gmail.com',
            'pangkat_jabatan_id' => 1,
            'jabatan_id' => 6,
            'unit_id' => 1,
            'password' => Hash::make('33333'),
        ]);
    }
}
