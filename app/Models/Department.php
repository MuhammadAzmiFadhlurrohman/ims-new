<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class, 'department_code', 'code');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'department_code', 'code');
    }
}
