<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $primaryKey = 'nidn';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nidn',
        'nama',
    ];

    public function jadwal(): HasMany
    {
        return $this->hasMany(
            Jadwal::class,
            'nidn',
            'nidn'
        );
    }
}