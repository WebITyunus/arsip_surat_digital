<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Perdir extends Model
{
    protected $table='peraturan_direktur';
    protected $fillable = ['nomor_surat','tanggal_surat','isi','author_id'];

      public function author(): BelongsTo
    {
        // Parameter: (NamaModelInduk, foreign_key_di_tabel_ini)
        return $this->belongsTo(User::class, 'author_id');
    }
        public function files(): MorphMany
    {
        return $this->morphMany(SuratFile::class, 'fileable');
    }
}
