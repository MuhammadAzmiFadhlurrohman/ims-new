<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageMutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'internet_number',
        'old_package_code',
        'new_package_code',
        'status',
        'requested_at',
        'effective_at',
        'schedule_date',
        'schedule_note',
        'closed_at',
        'closing_note',
        'proof_file',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'effective_at' => 'datetime',
            'schedule_date' => 'date',
            'closed_at' => 'date',
        ];
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(CustomerSubscription::class, 'internet_number', 'internet_number');
    }

    public function oldPackage(): BelongsTo
    {
        return $this->belongsTo(BandwidthPackage::class, 'old_package_code', 'code');
    }

    public function newPackage(): BelongsTo
    {
        return $this->belongsTo(BandwidthPackage::class, 'new_package_code', 'code');
    }
}
