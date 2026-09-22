<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_surat_keputusan', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal_surat')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->text('isi')->nullable();
            $table->string('arsip')->nullable();

            $table->foreignId('author_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_surat_keputusan');
    }
};
