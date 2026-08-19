<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Olt extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'pop_code',
        'name',
        'ip_address',
        'brand',
        'total_pon_ports',
    ];

    public function pop(): BelongsTo
    {
        return $this->belongsTo(Pop::class, 'pop_code', 'code');
    }

    public function ponPorts(): HasMany
    {
        return $this->hasMany(PonPort::class, 'olt_code', 'code');
    }

    public function odps(): HasMany
    {
        return $this->hasMany(Odp::class, 'olt_code', 'code');
    }
}
