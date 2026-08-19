<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PonPort extends Model
{
    use HasFactory;

    protected $fillable = [
        'olt_code',
        'name',
        'port_number',
        'max_ports',
        'used_ports',
        'total_subscribers',
    ];

    public function olt(): BelongsTo
    {
        return $this->belongsTo(Olt::class, 'olt_code', 'code');
    }

    public function odps()
    {
        return $this->hasMany(Odp::class, 'pon_port_id', 'id');
    }
}
