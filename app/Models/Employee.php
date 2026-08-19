<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

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
