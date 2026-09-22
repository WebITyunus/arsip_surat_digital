<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'kode_unit',
        'nama_unit',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function spos()
    {
        return $this->hasMany(Spo::class);
    }
}
