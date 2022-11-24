<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cctv extends Model
{
    use HasFactory;

    protected $fillable = ['location_id', 'kelurahan_id', 'user_id', 'status', 'name', 'liveViewUrl', 'rt', 'rw', 'latitude', 'longitude', 'ipaddress', 'username_cctv', 'password_cctv', 'note'];

    const STATUS_HIDUP = [
        '1',
        'Hidup'
    ];
    const STATUS_MATI = [
        '2',
        'Mati'
    ];
    const STATUS = [self::STATUS_HIDUP, self::STATUS_MATI];
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
        $cctv = Cctv::orderBy('status', 'asc')->orderBy('location_id', 'asc')->orderBy('name', 'asc')->orderBy('kelurahan_id', 'asc');
        if ($user != 'SUPERADMIN') {
            return $cctv->where('user_id', Auth::user()->id)->paginate();
        } else {
            return $cctv->paginate();
        }
    }
    public function getKelurahan()
    {
        $kelurahan = $this->kelurahan->nama_kelurahan ?? '';
        $kecamatan = $this->kelurahan->kecamatan->nama_kecamatan ?? '';
        if ($kelurahan && $kecamatan) {
            return $kecamatan . ' / ' . $kelurahan;
        } else {
            return 'Data Kosong';
        }
    }
    public function getStatus()
    {
        if ($this->status == 1) {
            return ['Hidup', 'success'];
        } else {
            return ['Mati', 'danger'];
        }
    }
}
