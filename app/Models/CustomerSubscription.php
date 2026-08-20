<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CustomerSubscription extends Model
{
    use HasFactory, LogsActivity;

    protected $primaryKey = 'internet_number';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['customer_name', 'registration_status', 'is_isolated', 'is_terminated', 'package_code', 'ip_address'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('subscription_audit');
    }

    protected $casts = [
        'is_isolated' => 'boolean',
        'is_terminated' => 'boolean',
        'is_locked' => 'boolean',
        'is_installable' => 'boolean',
        'discount_amount' => 'decimal:2',
        'survey_date' => 'date',
        'survey_finished_at' => 'date',
        'survey_team' => 'array',
        'survey_equipment' => 'array',
        'installation_date' => 'date',
        'installation_finished_at' => 'date',
        'installation_team' => 'array',
        'installation_equipment' => 'array',
        'activation_date' => 'date',
        'activation_finished_at' => 'date',
        'activation_team' => 'array',
        'activation_equipment' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (CustomerSubscription $subscription) {
            if (empty($subscription->ont_username) && !empty($subscription->internet_number)) {
                $cleanNum = preg_replace('/[^0-9]/', '', $subscription->internet_number);
                $subscription->ont_username = !empty($cleanNum) ? $cleanNum : $subscription->internet_number;
            }
            if (empty($subscription->ont_password)) {
                $subscription->ont_password = (string) rand(100000, 999999);
            }
        });

        static::created(function (CustomerSubscription $subscription) {
            $cleanNumber = preg_replace('/[^0-9]/', '', $subscription->internet_number);
            if (empty($cleanNumber)) {
                $cleanNumber = substr(abs(crc32($subscription->internet_number)), 0, 8);
            }
            $invNumber = 'REG-' . $cleanNumber;

            \App\Models\RegistrationInvoice::firstOrCreate(
                ['invoice_number' => $invNumber],
                [
                    'internet_number' => $subscription->internet_number,
                    'registration_fee' => 100000,
                    'ppn_amount' => 0,
                    'total_amount' => 100000,
                    'payment_status' => 'UNPAID',
                    'payment_method' => 'Midtrans',
                ]
            );
        });

        static::deleting(function (CustomerSubscription $subscription) {
            $num = $subscription->internet_number;
            if (!empty($num)) {
                \App\Models\RegistrationInvoice::where('internet_number', $num)->delete();
                \App\Models\MonthlyInvoice::where('internet_number', $num)->delete();
                \App\Models\CustomerDevice::where('internet_number', $num)->delete();
                \App\Models\PackageMutation::where('internet_number', $num)->delete();
                \App\Models\ServiceSuspension::where('internet_number', $num)->delete();
                \App\Models\ServiceTermination::where('internet_number', $num)->delete();
                \App\Models\SubscriptionLog::where('internet_number', $num)->delete();
                \App\Models\Ticket::where('internet_number', $num)->delete();

                if (\Illuminate\Support\Facades\Schema::hasTable('installation_pipelines')) {
                    \Illuminate\Support\Facades\DB::table('installation_pipelines')->where('internet_number', $num)->delete();
                }
                if (\Illuminate\Support\Facades\Schema::hasTable('whatsapp_logs')) {
                    \Illuminate\Support\Facades\DB::table('whatsapp_logs')->where('internet_number', $num)->delete();
                }
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_nik', 'nik');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(BandwidthPackage::class, 'package_code', 'code');
    }

    public function pop(): BelongsTo
    {
        return $this->belongsTo(Pop::class, 'pop_code', 'code');
    }

    public function odp(): BelongsTo
    {
        return $this->belongsTo(Odp::class, 'odp_code', 'code');
    }

    public function olt(): BelongsTo
    {
        return $this->belongsTo(Olt::class, 'olt_code', 'code');
    }

    public function router(): BelongsTo
    {
        return $this->belongsTo(Router::class, 'router_id');
    }

    public function pipeline(): HasOne
    {
        return $this->hasOne(InstallationPipeline::class, 'internet_number', 'internet_number');
    }

    public function monthlyInvoices(): HasMany
    {
        return $this->hasMany(MonthlyInvoice::class, 'internet_number', 'internet_number');
    }

    public function registrationInvoices(): HasMany
    {
        return $this->hasMany(RegistrationInvoice::class, 'internet_number', 'internet_number');
    }

    public function devices(): HasMany
    {
        return $this->hasMany(CustomerDevice::class, 'internet_number', 'internet_number');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'internet_number', 'internet_number');
    }
}
