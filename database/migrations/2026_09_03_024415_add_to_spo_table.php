<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::table('spo', function (Blueprint $table) {
    $table->foreignId('unit_id')
        ->nullable()
        ->after('id')
        ->constrained('units')
        ->nullOnDelete();

    $table->unsignedInteger('tahun')
        ->nullable()
        ->after('tanggal_surat');

    $table->unsignedInteger('nomor')
        ->nullable()
        ->after('tahun');

    $table->index(['unit_id', 'tahun']);
    $table->index(['unit_id', 'tahun', 'nomor']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spo', function (Blueprint $table) {
            //
        });
    }
};
