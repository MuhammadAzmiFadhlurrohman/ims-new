<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use HasFactory, LogsActivity;

    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'department_code',
        'position_code',
        'name',
        'gender',
        'phone_number',
        'company_email',
        'status_contract',
        'is_active',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'department_code', 'position_code', 'company_email', 'status_contract', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('employee_audit');
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_code', 'code');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_code', 'code');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'employee_nik', 'nik');
    }
}
