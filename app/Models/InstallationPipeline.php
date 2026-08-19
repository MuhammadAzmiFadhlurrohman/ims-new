<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstallationPipeline extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected $casts = [
        'verified_at' => 'date',
        'survey_scheduled_at' => 'date',
        'survey_finished_at' => 'date',
        'installation_scheduled_at' => 'date',
        'installation_finished_at' => 'date',
        'activation_scheduled_at' => 'date',
        'activation_finished_at' => 'date',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(CustomerSubscription::class, 'internet_number', 'internet_number');
    }
}
