<?php

namespace Custom\KitchenManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Custom\KitchenManagement\Models\KitchenOrderStatus;
use Custom\KitchenManagement\Models\WorkingHours;
use Webkul\Sales\Models\Order;

class KitchenOrderController extends Controller
{
    /**
     * Display the kitchen dashboard.
     */
    public function dashboard()
    {
        $isKitchenOpen = WorkingHours::isKitchenOpen();
        
        $ordersByStatus = [
            'received_in_kitchen' => KitchenOrderStatus::getOrdersByStatus('received_in_kitchen'),
            'scheduled_for_next_day' => KitchenOrderStatus::getOrdersByStatus('scheduled_for_next_day'),
            'preparing' => KitchenOrderStatus::getOrdersByStatus('preparing'),
            'ready_for_delivery' => KitchenOrderStatus::getOrdersByStatus('ready_for_delivery'),
            'on_the_way' => KitchenOrderStatus::getOrdersByStatus('on_the_way'),
        ];
        
        return view('kitchen-management::dashboard', compact('ordersByStatus', 'isKitchenOpen'));
    }

    /**
     * Update kitchen status for an order.
     */
    public function updateStatus(Request $request, int $orderId)
    {
        $request->validate([
            'kitchen_status' => 'required|string',
            'notes' => 'nullable|string',
            'assigned_delivery_user_id' => 'nullable|integer',
        ]);

        $currentStatus = KitchenOrderStatus::getCurrentStatus($orderId);
        
        if (!$currentStatus) {
            return response()->json(['error' => 'Order not found in kitchen system'], 404);
        }

        $newStatus = $request->input('kitchen_status');
        
        // Validate status transition
        if (!KitchenOrderStatus::isValidTransition($currentStatus->kitchen_status, $newStatus)) {
            return response()->json(['error' => 'Invalid status transition'], 400);
        }

        // Check if kitchen is open for certain transitions
        if (in_array($newStatus, ['preparing']) && !WorkingHours::isKitchenOpen()) {
            return response()->json(['error' => 'Kitchen is currently closed'], 400);
        }

        // Update status
        KitchenOrderStatus::updateStatus(
            $orderId,
            $newStatus,
            $request->input('assigned_delivery_user_id'),
            $request->input('notes')
        );

        // Update main order status if needed
        $this->updateMainOrderStatus($orderId, $newStatus);

        return response()->json(['success' => 'Status updated successfully']);
    }

    /**
     * Get orders by kitchen status for API.
     */
    public function getOrdersByStatus(string $status)
    {
        $orders = KitchenOrderStatus::getOrdersByStatus($status);
        
        return response()->json([
            'status' => $status,
            'orders' => $orders,
        ]);
    }

    /**
     * Get order details for API.
     */
    public function getOrderDetails(int $orderId)
    {
        $order = Order::with(['items', 'addresses'])->find($orderId);
        $kitchenStatus = KitchenOrderStatus::getCurrentStatus($orderId);
        
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        
        return response()->json([
            'order' => $order,
            'kitchen_status' => $kitchenStatus,
        ]);
    }

    /**
     * Update main order status based on kitchen status.
     */
    private function updateMainOrderStatus(int $orderId, string $kitchenStatus): void
    {
        $order = Order::find($orderId);
        if (!$order) {
            return;
        }

        $statusMapping = config('kitchen-management.order_status_mapping');
        
        if (isset($statusMapping[$kitchenStatus])) {
            $newOrderStatus = $statusMapping[$kitchenStatus];
            $order->update(['status' => $newOrderStatus]);
        }
    }
} 