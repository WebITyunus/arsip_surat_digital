<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('spo', function (Blueprint $table) {
    $table->id();

    $table->foreignId('unit_id')
        ->nullable()
        ->constrained('units')
        ->nullOnDelete();

    $table->unsignedInteger('tahun');

    $table->unsignedInteger('nomor');

    $table->date('tanggal_surat');

    $table->text('isi')->nullable();

    $table->foreignId('author_id')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->timestamps();
    $table->softDeletes();

    $table->index(['unit_id', 'tahun']);
    $table->index('tanggal_surat');

    $table->unique(['unit_id', 'tahun', 'nomor']);
});
    }

    public function down(): void
    {
        Schema::dropIfExists('spo');
    }
};
