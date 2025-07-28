@extends('admin::layouts.content')

@section('page_title')
    {{ __('kitchen-management::app.dashboard.title') }}
@endsection

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('kitchen-management::app.dashboard.title') }}</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('kitchen-management.working-hours.index') }}" class="btn btn-primary">
                    <i class="fas fa-clock"></i>
                    {{ __('kitchen-management::app.dashboard.working_hours') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <!-- Kitchen Status -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($isKitchenOpen)
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                    <h4 class="mt-2">{{ __('kitchen-management::app.dashboard.kitchen_open') }}</h4>
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-clock fa-2x"></i>
                                    <h4 class="mt-2">{{ __('kitchen-management::app.dashboard.kitchen_closed') }}</h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders by Status -->
            <div class="row">
                <!-- Received in Kitchen -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-inbox"></i>
                                {{ __('kitchen-management::app.dashboard.received_in_kitchen') }}
                                <span class="badge badge-light">{{ $ordersByStatus['received_in_kitchen']->count() }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($ordersByStatus['received_in_kitchen']->count() > 0)
                                @foreach($ordersByStatus['received_in_kitchen'] as $orderStatus)
                                    @include('kitchen-management::partials.order-card', ['orderStatus' => $orderStatus])
                                @endforeach
                            @else
                                <p class="text-muted text-center">{{ __('kitchen-management::app.dashboard.no_orders') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Scheduled for Next Day -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar"></i>
                                {{ __('kitchen-management::app.dashboard.scheduled_for_next_day') }}
                                <span class="badge badge-light">{{ $ordersByStatus['scheduled_for_next_day']->count() }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($ordersByStatus['scheduled_for_next_day']->count() > 0)
                                @foreach($ordersByStatus['scheduled_for_next_day'] as $orderStatus)
                                    @include('kitchen-management::partials.order-card', ['orderStatus' => $orderStatus])
                                @endforeach
                            @else
                                <p class="text-muted text-center">{{ __('kitchen-management::app.dashboard.no_orders') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Preparing -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-utensils"></i>
                                {{ __('kitchen-management::app.dashboard.preparing') }}
                                <span class="badge badge-light">{{ $ordersByStatus['preparing']->count() }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($ordersByStatus['preparing']->count() > 0)
                                @foreach($ordersByStatus['preparing'] as $orderStatus)
                                    @include('kitchen-management::partials.order-card', ['orderStatus' => $orderStatus])
                                @endforeach
                            @else
                                <p class="text-muted text-center">{{ __('kitchen-management::app.dashboard.no_orders') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Ready for Delivery -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-check"></i>
                                {{ __('kitchen-management::app.dashboard.ready_for_delivery') }}
                                <span class="badge badge-light">{{ $ordersByStatus['ready_for_delivery']->count() }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($ordersByStatus['ready_for_delivery']->count() > 0)
                                @foreach($ordersByStatus['ready_for_delivery'] as $orderStatus)
                                    @include('kitchen-management::partials.order-card', ['orderStatus' => $orderStatus])
                                @endforeach
                            @else
                                <p class="text-muted text-center">{{ __('kitchen-management::app.dashboard.no_orders') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- On the Way -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-purple text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-truck"></i>
                                {{ __('kitchen-management::app.dashboard.on_the_way') }}
                                <span class="badge badge-light">{{ $ordersByStatus['on_the_way']->count() }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($ordersByStatus['on_the_way']->count() > 0)
                                @foreach($ordersByStatus['on_the_way'] as $orderStatus)
                                    @include('kitchen-management::partials.order-card', ['orderStatus' => $orderStatus])
                                @endforeach
                            @else
                                <p class="text-muted text-center">{{ __('kitchen-management::app.dashboard.no_orders') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-refresh dashboard every 30 seconds
        setInterval(function() {
            location.reload();
        }, 30000);
    </script>
    @endpush
@endsection 