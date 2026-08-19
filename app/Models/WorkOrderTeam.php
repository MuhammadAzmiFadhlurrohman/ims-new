<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'leader_name',
        'phone_number',
    ];
}
