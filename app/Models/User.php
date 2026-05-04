<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Penempatan;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Field yang boleh diisi mass assignment
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'wilayah',
    ];

    /**
     * Field disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting attribute
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function penempatans()
    {
        return $this->hasMany(Penempatan::class);
    }
}