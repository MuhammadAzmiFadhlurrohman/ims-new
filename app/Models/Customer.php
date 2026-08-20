<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Customer extends Model
{
    use HasFactory, LogsActivity;

    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Strict Mass Assignment Whitelist
     */
    protected $fillable = [
        'nik',
        'name',
        'gender',
        'birth_date',
        'birth_place',
        'phone_number',
        'email',
        'id_card_address',
        'npwp',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'phone_number', 'email', 'id_card_address'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('customer_audit');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(CustomerSubscription::class, 'customer_nik', 'nik');
    }
}
