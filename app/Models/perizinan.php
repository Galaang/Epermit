<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perizinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'nip',
        'pangkat_jabatan',
        'jabatan',
        'unit_kerja',
        'jenis_izin',
        'waktu',
        'izin_ke',
        'tanggal',
        'alasan'
    ];
}
