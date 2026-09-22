<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Spo extends Model
{
    protected $table='spo';
        protected $fillable = [
        'unit_id',
        'tahun',
        'nomor',
        'tanggal_surat',
        'nomor_surat',
        'isi',
        'author_id',
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
    public function unit()
{
    return $this->belongsTo(Unit::class);
}

}
