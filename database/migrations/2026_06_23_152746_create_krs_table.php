<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();

            $table->string('npm', 10);
            $table->string('kode_matakuliah', 8);

            $table->timestamps();

            $table->foreign('npm')
                ->references('npm')
                ->on('mahasiswa')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('kode_matakuliah')
                ->references('kode_matakuliah')
                ->on('matakuliah')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->unique(
                ['npm', 'kode_matakuliah'],
                'krs_npm_matakuliah_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};