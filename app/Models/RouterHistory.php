<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouterHistory extends Model
{
    use HasFactory;

    protected $table = 'router_histories';

    protected $fillable = [
        'router_id',
        'internet_number',
        'customer_name',
        'executor_name',
        'executor_role',
        'action_type',
        'old_status',
        'new_status',
        'description',
        'response_message',
        'status',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
    ];

    public function router(): BelongsTo
    {
        return $this->belongsTo(Router::class, 'router_id');
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(CustomerSubscription::class, 'internet_number', 'internet_number');
    }

    /**
     * Helper to quickly log a router action
     */
    public static function log(
        string $actionType,
        ?string $internetNumber = null,
        ?string $customerName = null,
        ?string $description = null,
        ?string $responseMessage = null,
        ?string $oldStatus = null,
        ?string $newStatus = null,
        ?int $routerId = null,
        string $status = 'success',
        ?array $payload = null
    ): self {
        $user = auth()->user();
        $executorName = $user ? $user->name : 'System / Auto';
        $executorRole = $user && method_exists($user, 'getRoleNames') && $user->getRoleNames()->first()
            ? $user->getRoleNames()->first()
            : ($user ? 'admin' : 'system');

        return self::create([
            'router_id' => $routerId,
            'internet_number' => $internetNumber,
            'customer_name' => $customerName,
            'executor_name' => $executorName,
            'executor_role' => $executorRole,
            'action_type' => $actionType,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'description' => $description,
            'response_message' => $responseMessage,
            'status' => $status,
            'payload' => $payload,
        ]);
    }
}
