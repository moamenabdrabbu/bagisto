<?php

namespace Custom\KitchenManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Sales\Models\Order;

class KitchenOrderStatus extends Model
{
    protected $table = 'kitchen_order_statuses';

    protected $fillable = [
        'order_id',
        'kitchen_status',
        'assigned_delivery_user_id',
        'notes',
        'status_changed_at',
    ];

    protected $casts = [
        'status_changed_at' => 'datetime',
    ];

    /**
     * Get the order that owns the kitchen status.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the current kitchen status for an order.
     */
    public static function getCurrentStatus(int $orderId): ?self
    {
        return self::where('order_id', $orderId)
            ->orderBy('status_changed_at', 'desc')
            ->first();
    }

    /**
     * Update kitchen status for an order.
     */
    public static function updateStatus(
        int $orderId,
        string $kitchenStatus,
        ?int $assignedDeliveryUserId = null,
        ?string $notes = null,
        ?int $changedBy = null,
        ?string $changedByType = 'admin'
    ): self {
        // Create new status record
        $status = self::create([
            'order_id' => $orderId,
            'kitchen_status' => $kitchenStatus,
            'assigned_delivery_user_id' => $assignedDeliveryUserId,
            'notes' => $notes,
            'status_changed_at' => now(),
        ]);

        // Log the status change
        KitchenStatusLog::create([
            'order_id' => $orderId,
            'from_status' => self::getCurrentStatus($orderId)?->kitchen_status,
            'to_status' => $kitchenStatus,
            'changed_by' => $changedBy ?? auth()->id(),
            'changed_by_type' => $changedByType,
            'notes' => $notes,
        ]);

        return $status;
    }

    /**
     * Get orders by kitchen status.
     */
    public static function getOrdersByStatus(string $kitchenStatus): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('kitchen_status', $kitchenStatus)
            ->with('order')
            ->orderBy('status_changed_at', 'asc')
            ->get();
    }

    /**
     * Check if status transition is valid.
     */
    public static function isValidTransition(string $fromStatus, string $toStatus): bool
    {
        $validTransitions = [
            'received_in_kitchen' => ['preparing', 'canceled'],
            'scheduled_for_next_day' => ['preparing', 'canceled'],
            'preparing' => ['ready_for_delivery', 'canceled'],
            'ready_for_delivery' => ['on_the_way', 'canceled'],
            'on_the_way' => ['delivered', 'delivery_failed'],
            'delivered' => [],
            'delivery_failed' => [],
        ];

        return in_array($toStatus, $validTransitions[$fromStatus] ?? []);
    }

    /**
     * Get kitchen status label.
     */
    public function getStatusLabelAttribute(): string
    {
        $statuses = config('kitchen-management.kitchen_statuses');
        
        return $statuses[$this->kitchen_status]['label'] ?? $this->kitchen_status;
    }

    /**
     * Get kitchen status color.
     */
    public function getStatusColorAttribute(): string
    {
        $statuses = config('kitchen-management.kitchen_statuses');
        
        return $statuses[$this->kitchen_status]['color'] ?? 'default';
    }
} 