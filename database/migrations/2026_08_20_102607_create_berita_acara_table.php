<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal_surat');
            $table->string('nomor_surat', 150);

            $table->text('tujuan_surat')->nullable();
            $table->text('isi')->nullable();

            $table->foreignId('author_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('tanggal_surat');
            $table->index('nomor_surat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
