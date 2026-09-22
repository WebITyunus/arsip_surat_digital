<?php

namespace App\Models;

use App\Models\SuratFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Pokjars extends Model
{
    protected $table='surat_pokjars';
    protected $fillable = ['nomor_surat','isi','tanggal_surat','author_id','pokja_id'];

    public function author(): BelongsTo
    {
     return  $this->belongsTo(User::class,'author_id');
    }

        public function pokjars(): BelongsTo
    {
     return  $this->belongsTo(pokja::class,'pokja_id');
    }

            public function files(): MorphMany
    {
        return $this->morphMany(SuratFile::class, 'fileable');
    }


}
