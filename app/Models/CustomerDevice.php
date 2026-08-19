<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerDevice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'installed_at' => 'date',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(CustomerSubscription::class, 'internet_number', 'internet_number');
    }
}
