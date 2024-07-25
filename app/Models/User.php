<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'unit_id',
        'pangkat_jabatan_id',
        'jabatan_id',
        'nip',
        'password',
    ];

    public function role(): BelongsTo  //untuk relasi ke tabel role
    {
        return $this->belongsTo(Role::class);
    }
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit_kerja::class);
    }
    public function pangkat_jabatan(): BelongsTo
    {
        return $this->belongsTo(pangkat_jabatan::class);
    }
    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(jabatan::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
