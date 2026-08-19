<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceSuspension extends Model
{
    use HasFactory;

    protected $fillable = [
        'internet_number',
        'reason',
        'suspended_at',
        'unsuspended_at',
        'start_suspend_date',
        'send_whatsapp',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'suspended_at' => 'datetime',
            'unsuspended_at' => 'datetime',
            'start_suspend_date' => 'date',
            'send_whatsapp' => 'boolean',
        ];
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(CustomerSubscription::class, 'internet_number', 'internet_number');
    }
}
