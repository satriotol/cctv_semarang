<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cctv extends Model
{
    use HasFactory;

    protected $fillable = ['location_id', 'kelurahan_id', 'user_id', 'status', 'name', 'liveViewUrl', 'rt', 'rw', 'latitude', 'longitude', 'ipaddress', 'username_cctv', 'password_cctv', 'note'];
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id', 'id_kelurahan');
    }
}
