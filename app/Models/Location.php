<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function cctvs()
    {
        return $this->hasMany(Cctv::class, 'location_id', 'id');
    }
}
