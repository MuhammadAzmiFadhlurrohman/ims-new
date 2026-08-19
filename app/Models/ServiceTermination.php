<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceTermination extends Model
{
    use HasFactory;

    protected $fillable = [
        'internet_number',
        'termination_code',
        'reason',
        'device_returned',
        'terminated_at',
        'status',
        'schedule_collect_date',
        'schedule_collect_time',
        'collect_team',
        'collect_note',
        'collect_finished_at',
        'collect_finished_note',
        'closing_date',
        'closing_note',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'device_returned' => 'boolean',
            'terminated_at' => 'datetime',
            'schedule_collect_date' => 'date',
            'collect_finished_at' => 'date',
            'closing_date' => 'date',
            'collect_team' => 'array',
        ];
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(CustomerSubscription::class, 'internet_number', 'internet_number');
    }
}
