<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_files', function (Blueprint $table) {
            $table->id();

            $table->string('fileable_type');
            $table->unsignedBigInteger('fileable_id');

            $table->unsignedBigInteger('old_id')->nullable();

            $table->string('nama_file');
            $table->string('nama_asli')->nullable();
            $table->string('path');

            $table->timestamps();

            $table->index([
                'fileable_type',
                'fileable_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_files');
    }
};
