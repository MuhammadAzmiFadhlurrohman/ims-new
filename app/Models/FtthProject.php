<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FtthProject extends Model
{
    use HasFactory;

    protected $table = 'ftth_projects';

    protected $fillable = [
        'name',
        'code',
        'description',
        'color',
        'center_latitude',
        'center_longitude',
        'default_zoom',
        'is_active',
    ];

    protected $casts = [
        'center_latitude' => 'float',
        'center_longitude' => 'float',
        'default_zoom' => 'integer',
        'is_active' => 'boolean',
    ];

    public function elements(): HasMany
    {
        return $this->hasMany(FtthNetworkElement::class, 'project_id');
    }
}
