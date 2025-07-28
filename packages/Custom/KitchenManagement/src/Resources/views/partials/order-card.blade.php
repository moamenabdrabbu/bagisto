<div class="order-card mb-3 p-3 border rounded">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h6 class="mb-1">#{{ $orderStatus->order->increment_id }}</h6>
            <small class="text-muted">
                {{ $orderStatus->order->created_at->format('M d, Y H:i') }}
            </small>
        </div>
        <div class="text-right">
            <span class="badge badge-{{ $orderStatus->status_color }}">
                {{ $orderStatus->status_label }}
            </span>
        </div>
    </div>
    
    <div class="mt-2">
        <strong>{{ __('kitchen-management::app.dashboard.customer') }}:</strong>
        {{ $orderStatus->order->customer_full_name }}
    </div>
    
    <div class="mt-1">
        <strong>{{ __('kitchen-management::app.dashboard.total') }}:</strong>
        {{ core()->formatPrice($orderStatus->order->grand_total) }}
    </div>
    
    @if($orderStatus->order->items->count() > 0)
        <div class="mt-2">
            <strong>{{ __('kitchen-management::app.dashboard.items') }}:</strong>
            <ul class="list-unstyled mb-0">
                @foreach($orderStatus->order->items->take(3) as $item)
                    <li class="small">{{ $item->name }} ({{ $item->qty_ordered }})</li>
                @endforeach
                @if($orderStatus->order->items->count() > 3)
                    <li class="small text-muted">+{{ $orderStatus->order->items->count() - 3 }} more</li>
                @endif
            </ul>
        </div>
    @endif
    
    <div class="mt-3">
        <div class="btn-group btn-group-sm w-100">
            @if($orderStatus->kitchen_status === 'received_in_kitchen' && $isKitchenOpen)
                <button type="button" 
                        class="btn btn-info btn-sm"
                        onclick="updateOrderStatus({{ $orderStatus->order_id }}, 'preparing')">
                    <i class="fas fa-utensils"></i>
                    {{ __('kitchen-management::app.dashboard.start_preparing') }}
                </button>
            @endif
            
            @if($orderStatus->kitchen_status === 'scheduled_for_next_day' && $isKitchenOpen)
                <button type="button" 
                        class="btn btn-info btn-sm"
                        onclick="updateOrderStatus({{ $orderStatus->order_id }}, 'preparing')">
                    <i class="fas fa-utensils"></i>
                    {{ __('kitchen-management::app.dashboard.start_preparing') }}
                </button>
            @endif
            
            @if($orderStatus->kitchen_status === 'preparing')
                <button type="button" 
                        class="btn btn-success btn-sm"
                        onclick="updateOrderStatus({{ $orderStatus->order_id }}, 'ready_for_delivery')">
                    <i class="fas fa-check"></i>
                    {{ __('kitchen-management::app.dashboard.ready_for_delivery') }}
                </button>
            @endif
            
            @if($orderStatus->kitchen_status === 'ready_for_delivery')
                <button type="button" 
                        class="btn btn-primary btn-sm"
                        onclick="assignDelivery({{ $orderStatus->order_id }})">
                    <i class="fas fa-truck"></i>
                    {{ __('kitchen-management::app.dashboard.assign_delivery') }}
                </button>
            @endif
        </div>
    </div>
</div>

<script>
function updateOrderStatus(orderId, status) {
    if (confirm('{{ __("kitchen-management::app.dashboard.confirm_status_change") }}')) {
        fetch(`/kitchen-management/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                kitchen_status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the status.');
        });
    }
}

function assignDelivery(orderId) {
    // This will be implemented when we add delivery management
    alert('Delivery assignment feature will be available in the next phase.');
}
</script> 