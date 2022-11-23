<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    protected $table = 'kelurahan';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('nama_kelurahan', 'asc');
        });
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'relasi_kecamatan', 'id_kecamatan');
    }
}
