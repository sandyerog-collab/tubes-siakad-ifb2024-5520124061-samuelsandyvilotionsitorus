<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropUnique(['nim']);
            $table->dropColumn('nim');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('nim', 10)
                ->nullable()
                ->unique()
                ->after('npm');
        });
    }
};