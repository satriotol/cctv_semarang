<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public static function getCctv()
    {
        $user = User::getUserRole(Auth::user());
        $cctv = Cctv::orderBy('location_id', 'desc')->orderBy('name', 'asc')->orderBy('kelurahan_id', 'asc');
        if ($user != 'SUPERADMIN') {
            return $cctv->where('user_id', Auth::user()->id)->paginate();
        } else {
            return $cctv->paginate();
        }
    }
}
