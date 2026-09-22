<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal_diterima');
            $table->date('tanggal_surat');

            $table->string('nomor_surat', 150);
            $table->string('asal_surat', 255);

            $table->text('isi')->nullable();

            $table->string('nomor_disposisi', 100)->nullable();
            $table->text('diteruskan')->nullable();

            $table->foreignId('author_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('editor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('tanggal_surat');
            $table->index('nomor_surat');
            $table->index('asal_surat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
