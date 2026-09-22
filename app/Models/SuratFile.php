<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SuratFile extends Model
{
    protected $fillable = [
        'fileable_type',
        'fileable_id',
        'old_id',
        'nama_file',
        'nama_asli',
        'path',
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function files(): MorphMany
{
    return $this->morphMany(SuratFile::class, 'fileable');
}

}
