<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kitchen Management Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the kitchen management package.
    |
    */

    'name' => env('KITCHEN_MANAGEMENT_NAME', 'Kitchen Management'),
    
    'enabled' => env('KITCHEN_MANAGEMENT_ENABLED', true),
    
    /*
    |--------------------------------------------------------------------------
    | Kitchen Statuses
    |--------------------------------------------------------------------------
    |
    | Define the available kitchen statuses and their order in the workflow.
    |
    */
    'kitchen_statuses' => [
        'received_in_kitchen' => [
            'label' => 'Received in Kitchen',
            'color' => 'blue',
            'order' => 1,
        ],
        'scheduled_for_next_day' => [
            'label' => 'Scheduled for Next Day',
            'color' => 'orange',
            'order' => 1,
        ],
        'preparing' => [
            'label' => 'Preparing',
            'color' => 'yellow',
            'order' => 2,
        ],
        'ready_for_delivery' => [
            'label' => 'Ready for Delivery',
            'color' => 'green',
            'order' => 3,
        ],
        'on_the_way' => [
            'label' => 'On the Way',
            'color' => 'purple',
            'order' => 4,
        ],
        'delivered' => [
            'label' => 'Delivered',
            'color' => 'success',
            'order' => 5,
        ],
        'delivery_failed' => [
            'label' => 'Delivery Failed',
            'color' => 'danger',
            'order' => 5,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Working Hours Default Configuration
    |--------------------------------------------------------------------------
    |
    | Default working hours for the kitchen (Saturday to Friday).
    |
    */
    'default_working_hours' => [
        'saturday' => [
            'is_working_day' => true,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ],
        'sunday' => [
            'is_working_day' => false,
            'start_time' => null,
            'end_time' => null,
        ],
        'monday' => [
            'is_working_day' => true,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ],
        'tuesday' => [
            'is_working_day' => true,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ],
        'wednesday' => [
            'is_working_day' => true,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ],
        'thursday' => [
            'is_working_day' => true,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ],
        'friday' => [
            'is_working_day' => true,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Order Status Mapping
    |--------------------------------------------------------------------------
    |
    | Map kitchen statuses to main order statuses when completed.
    |
    */
    'order_status_mapping' => [
        'delivered' => 'completed',
        'delivery_failed' => 'closed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cancellation Rules
    |--------------------------------------------------------------------------
    |
    | Define when orders can be canceled based on kitchen status.
    |
    */
    'cancellation_rules' => [
        'allow_cancel_until_status' => 'preparing',
        'refund_allowed_until_status' => 'preparing',
    ],
]; 