<?php

namespace Custom\KitchenManagement\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Webkul\Sales\Models\Order;
use Custom\KitchenManagement\Models\WorkingHours;
use Custom\KitchenManagement\Models\KitchenOrderStatus;

class OrderStatusListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        $order = $event->order;
        
        // Only process orders that are in "processing" status
        if ($order->status !== Order::STATUS_PROCESSING) {
            return;
        }

        // Check if kitchen status already exists
        $existingStatus = KitchenOrderStatus::getCurrentStatus($order->id);
        if ($existingStatus) {
            return;
        }

        // Determine initial kitchen status based on working hours
        $kitchenStatus = $this->determineInitialKitchenStatus();
        
        // Create initial kitchen status
        KitchenOrderStatus::updateStatus(
            $order->id,
            $kitchenStatus,
            null,
            'Automatically assigned based on kitchen working hours'
        );
    }

    /**
     * Determine the initial kitchen status based on working hours.
     */
    private function determineInitialKitchenStatus(): string
    {
        if (WorkingHours::isKitchenOpen()) {
            return 'received_in_kitchen';
        }

        return 'scheduled_for_next_day';
    }
} 