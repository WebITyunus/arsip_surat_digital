<?php

namespace App\Models;

use App\Models\Pokjars;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pokja extends Model
{
    protected $table='pokjars';
    protected $fillable = ['nama','kode'];

        public function pokjar():HasMany{
    return $this->hasMany(Pokjars::class,'pokja_id');
    }
}
