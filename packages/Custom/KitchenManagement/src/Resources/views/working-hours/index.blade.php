@extends('admin::layouts.content')

@section('page_title')
    {{ __('kitchen-management::app.working-hours.title') }}
@endsection

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('kitchen-management::app.working-hours.title') }}</h1>
            </div>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ __('kitchen-management::app.working-hours.configure') }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kitchen-management.working-hours.update') }}" method="POST">
                                @csrf
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('kitchen-management::app.working-hours.day') }}</th>
                                                <th>{{ __('kitchen-management::app.working-hours.working_day') }}</th>
                                                <th>{{ __('kitchen-management::app.working-hours.start_time') }}</th>
                                                <th>{{ __('kitchen-management::app.working-hours.end_time') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                                @php
                                                    $workingHour = $workingHours[$day] ?? null;
                                                    $isWorkingDay = $workingHour ? $workingHour->is_working_day : false;
                                                    $startTime = $workingHour ? $workingHour->start_time : null;
                                                    $endTime = $workingHour ? $workingHour->end_time : null;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <strong>{{ __('kitchen-management::app.working-hours.days.' . $day) }}</strong>
                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" 
                                                                   class="form-check-input working-day-checkbox" 
                                                                   name="working_hours[{{ $day }}][is_working_day]" 
                                                                   value="1" 
                                                                   {{ $isWorkingDay ? 'checked' : '' }}
                                                                   data-day="{{ $day }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="time" 
                                                               class="form-control time-input" 
                                                               name="working_hours[{{ $day }}][start_time]" 
                                                               value="{{ $startTime ? $startTime->format('H:i') : '' }}"
                                                               data-day="{{ $day }}"
                                                               {{ !$isWorkingDay ? 'disabled' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input type="time" 
                                                               class="form-control time-input" 
                                                               name="working_hours[{{ $day }}][end_time]" 
                                                               value="{{ $endTime ? $endTime->format('H:i') : '' }}"
                                                               data-day="{{ $day }}"
                                                               {{ !$isWorkingDay ? 'disabled' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('kitchen-management::app.working-hours.update') }}
                                    </button>
                                    <a href="{{ route('kitchen-management.dashboard') }}" class="btn btn-secondary">
                                        {{ __('kitchen-management::app.working-hours.cancel') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ __('kitchen-management::app.working-hours.current_status') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                @if($isKitchenOpen)
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i>
                                        <strong>{{ __('kitchen-management::app.working-hours.kitchen_open') }}</strong>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-clock"></i>
                                        <strong>{{ __('kitchen-management::app.working-hours.kitchen_closed') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle working day checkbox changes
            document.querySelectorAll('.working-day-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const day = this.dataset.day;
                    const timeInputs = document.querySelectorAll(`.time-input[data-day="${day}"]`);
                    
                    timeInputs.forEach(function(input) {
                        input.disabled = !checkbox.checked;
                        if (!checkbox.checked) {
                            input.value = '';
                        }
                    });
                });
            });
        });
    </script>
    @endpush
@endsection 