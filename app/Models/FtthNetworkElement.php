<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FtthNetworkElement extends Model
{
    use HasFactory;

    protected $table = 'ftth_network_elements';

    protected $guarded = [];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'path_coordinates' => 'array',
        'metadata' => 'array',
        'length_meters' => 'integer',
    ];

    public function olt(): BelongsTo
    {
        return $this->belongsTo(Olt::class, 'olt_code', 'code');
    }
}
