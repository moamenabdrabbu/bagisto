@extends('shop::layouts.master')

@section('page_title')
    {{ __('payment-gateway::app.payment.title') }}
@endsection

@section('content-wrapper')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('payment-gateway::app.payment.title') }}</h3>
                    </div>
                    <div class="card-body">
                        <p>{{ __('payment-gateway::app.payment.description') }}</p>
                        
                        <form action="{{ route('payment-gateway.process') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="amount">{{ __('payment-gateway::app.payment.amount') }}</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                {{ __('payment-gateway::app.payment.process') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 