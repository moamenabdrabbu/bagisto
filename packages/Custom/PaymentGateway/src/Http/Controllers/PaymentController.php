<?php

namespace Custom\PaymentGateway\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PaymentController extends Controller
{
    /**
     * Display the payment gateway index page.
     */
    public function index()
    {
        return view('payment-gateway::index');
    }

    /**
     * Process the payment.
     */
    public function process(Request $request)
    {
        // Payment processing logic here
        return response()->json(['status' => 'success']);
    }

    /**
     * Handle payment callback.
     */
    public function callback(Request $request)
    {
        // Callback handling logic here
        return response()->json(['status' => 'received']);
    }
} 