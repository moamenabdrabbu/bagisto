<?php

namespace Custom\KitchenManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Sales\Models\Order;

class KitchenStatusLog extends Model
{
    protected $table = 'kitchen_status_logs';

    protected $fillable = [
        'order_id',
        'from_status',
        'to_status',
        'changed_by',
        'changed_by_type',
        'notes',
    ];

    /**
     * Get the order that owns the status log.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get status logs for an order.
     */
    public static function getLogsForOrder(int $orderId): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('order_id', $orderId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get status change history.
     */
    public static function getStatusHistory(int $orderId): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('order_id', $orderId)
            ->orderBy('created_at', 'asc')
            ->get();
    }
} 