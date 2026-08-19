<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BandwidthCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected $casts = [
        'has_registration_ppn' => 'boolean',
        'has_billing_ppn' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(BandwidthPackage::class, 'category_code', 'code');
    }

    public function buildingServiceCategories(): HasMany
    {
        return $this->hasMany(BuildingServiceCategory::class, 'bandwidth_category_code', 'code');
    }

    public function buildingTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            BuildingType::class,
            'building_service_categories',
            'bandwidth_category_code',
            'building_type_code',
            'code',
            'code'
        );
    }
}
