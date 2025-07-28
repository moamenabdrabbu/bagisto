# Kitchen Management Package

A comprehensive kitchen management system for Centurion (Bagisto) that handles working hours, order statuses, and kitchen workflow.

## Features

### Working Hours Management
- Configure working hours for each day of the week (Saturday to Friday)
- Enable/disable working days
- Set start and end times for each working day
- Real-time kitchen status based on working hours

### Kitchen Order Statuses
- **Received in Kitchen**: Orders received during working hours
- **Scheduled for Next Day**: Orders received outside working hours
- **Preparing**: Orders being prepared in the kitchen
- **Ready for Delivery**: Orders ready for delivery assignment
- **On the Way**: Orders being delivered
- **Delivered**: Orders successfully delivered
- **Delivery Failed**: Orders that failed to be delivered

### Order Flow Logic
- Automatic kitchen status assignment based on working hours
- Status transition validation
- Integration with main order statuses
- Comprehensive status logging

## Installation

1. The package is already included in the `packages/Custom/KitchenManagement` directory
2. The service provider is registered in `bootstrap/providers.php`
3. The autoload configuration is added to `composer.json`

## Database Setup

Run the migrations to create the necessary tables:

```bash
php artisan migrate
```

Seed the default working hours:

```bash
php artisan db:seed --class="Custom\KitchenManagement\Database\Seeders\WorkingHoursSeeder"
```

## Configuration

The package configuration is located in `packages/Custom/KitchenManagement/src/Config/kitchen-management.php`.

### Environment Variables

Add the following to your `.env` file:

```env
KITCHEN_MANAGEMENT_NAME="Kitchen Management"
KITCHEN_MANAGEMENT_ENABLED=true
```

## Usage

### Admin Interface

1. **Working Hours Configuration**: `/kitchen-management/working-hours`
2. **Kitchen Dashboard**: `/kitchen-management/dashboard`

### API Endpoints

- `GET /api/kitchen-management/working-hours` - Get working hours configuration
- `GET /api/kitchen-management/kitchen-status` - Get current kitchen status
- `GET /api/kitchen-management/orders/status/{status}` - Get orders by kitchen status
- `GET /api/kitchen-management/orders/{orderId}` - Get order details
- `PUT /api/kitchen-management/orders/{orderId}/status` - Update order kitchen status

## Order Status Integration

The package automatically integrates with the main order system:

- When an order reaches "Processing" status, it automatically gets a kitchen status
- Kitchen statuses map to main order statuses when completed
- Status changes are logged for audit purposes

## Development

### Adding New Kitchen Statuses

1. Add the status to the configuration in `kitchen-management.php`
2. Update the status transition logic in `KitchenOrderStatus` model
3. Add corresponding UI elements in the dashboard

### Customizing Working Hours Logic

Modify the `WorkingHours` model to implement custom business logic for:
- Holiday handling
- Special working hours
- Time zone considerations

## Next Steps

This package is designed to work with the upcoming Delivery Management package, which will handle:
- Delivery user registration and management
- Mobile app integration
- Real-time delivery tracking
- Delivery assignment and routing 