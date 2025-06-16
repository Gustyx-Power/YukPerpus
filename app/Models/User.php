<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'foto',
        'level',
        'no_hp',
        'alamat',
        'google_id',
        'github_id',
    ];

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
        'password' => 'hashed',
    ];

    /**
     * Get the URL for the user's profile photo.
     */
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('assets/images/default-profile.png');
    }

    /**
     * Get the user's name.
     */
    public function getNameAttribute()
    {
        return $this->nama;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->level === 'admin';
    }

    /**
     * Check if user is petugas
     */
    public function isPetugas(): bool
    {
        return $this->level === 'petugas';
    }

    /**
     * Check if user is regular member
     */
    public function isAnggota(): bool
    {
        return $this->level === 'anggota';
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
