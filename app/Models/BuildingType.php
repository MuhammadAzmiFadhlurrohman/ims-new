<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuildingType extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function serviceCategories(): HasMany
    {
        return $this->hasMany(BuildingServiceCategory::class, 'building_type_code', 'code');
    }

    public function bandwidthCategories(): BelongsToMany
    {
        return $this->belongsToMany(
            BandwidthCategory::class,
            'building_service_categories',
            'building_type_code',
            'bandwidth_category_code',
            'code',
            'code'
        );
    }
}
