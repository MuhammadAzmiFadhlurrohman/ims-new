<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(CustomerSubscription::class, 'customer_nik', 'nik');
    }
}
