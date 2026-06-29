<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'kode_matakuliah',
        'nidn',
        'kelas',
        'hari',
        'jam',
    ];

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(
            Dosen::class,
            'nidn',
            'nidn'
        );
    }

    public function matakuliah(): BelongsTo
    {
        return $this->belongsTo(
            Matakuliah::class,
            'kode_matakuliah',
            'kode_matakuliah'
        );
    }
}