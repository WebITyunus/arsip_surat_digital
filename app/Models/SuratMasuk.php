<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';
   protected $fillable = [
    'tanggal_diterima',
    'tanggal_surat',
    'nomor_surat',
    'asal_surat',
    'isi',
    'nomor_disposisi',
    'diteruskan',
    'author_id',
    'editor_id',
];


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
