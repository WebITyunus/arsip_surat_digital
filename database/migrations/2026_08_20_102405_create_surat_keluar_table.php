<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal_surat');
            $table->date('tanggal_dikirim')->nullable();

            $table->string('nomor_surat', 150);

            $table->text('tujuan_surat');
            $table->string('asal_surat', 150)->nullable();

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
        Schema::dropIfExists('surat_keluar');
    }
};
