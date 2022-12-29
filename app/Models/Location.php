<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Location extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $fillable = ['name'];

    public function cctvs()
    {
        return $this->hasMany(Cctv::class, 'location_id', 'id');
    }
}
