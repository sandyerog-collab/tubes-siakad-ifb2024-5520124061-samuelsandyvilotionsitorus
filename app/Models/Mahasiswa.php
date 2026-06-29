<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'npm';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'npm',
        'nama',
    ];

    public function krs(): HasMany
    {
        return $this->hasMany(
            Krs::class,
            'npm',
            'npm'
        );
    }
}