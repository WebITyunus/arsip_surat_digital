<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


#[Fillable([    'name',
    'username',
    'email',
    'unit_id',
    'password',
    'is_active',])]

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $casts = [
    'is_active' => 'boolean',
];

        public function suratmasuk(): HasMany
    {
        // Parameter: (NamaModelTujuan, foreign_key_di_tabel_tujuan)
        return $this->hasMany(SuratMasuk::class, 'author_id');
    }

    public function unit()
{
    return $this->belongsTo(Unit::class);
}

public function spos()
{
    return $this->hasMany(Spo::class, 'author_id');
}

public function pokjars()
{
    return $this->hasMany(Pokjars::class, 'author_id');
}

}
