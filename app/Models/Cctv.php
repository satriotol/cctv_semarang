<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Cctv extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

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
        $cctv = Cctv::orderBy('status', 'asc')->orderBy('location_id', 'asc')->orderBy('name', 'asc')->orderBy('kelurahan_id', 'asc');

        if (Auth::user()) {
            $user = User::getUserRole(Auth::user());
            if ($user != 'SUPERADMIN') {
                return $cctv->where('user_id', Auth::user()->id);
            } else {
                return $cctv;
            }
        }
        return $cctv;
    }

    public static function getApiCctv($request)
    {
        $location_id = $request->location_id;
        $kelurahan_id = $request->kelurahan_id;
        $status = $request->status;
        $latlng = $request->latlng;
        $cctv = Cctv::with(['kelurahan.kecamatan', 'location']);
        if ($location_id) {
            $cctv->where('location_id', $location_id);
        }
        if ($kelurahan_id) {
            $cctv->where('kelurahan_id', $kelurahan_id);
        }
        if ($status) {
            $cctv->where('status', $status);
        } else {
            $cctv->where('status', 1);
        }
        if ($latlng) {
            $cctv->whereNotNull('latitude')->whereNotNull('longitude');
        }
        return $cctv;
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
