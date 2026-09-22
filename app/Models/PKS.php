<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PKS extends Model
{
    protected $table='pks';
    protected $fillable = ['tanggal_surat','nomor_surat','tujuan_surat','isi','tanggal_mulai','tanggal_berakhir','author_id'];

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
