# Custom Payment Gateway Package

This is a custom payment gateway package for Centurion (Bagisto).

## Installation

1. The package is already included in the `packages/Custom/PaymentGateway` directory
2. Register the service provider in your `config/app.php`:

```php
'providers' => [
    // ... other providers
    Custom\PaymentGateway\Providers\PaymentGatewayServiceProvider::class,
],
```

3. Add the autoload configuration to your main `composer.json`:

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Custom\\PaymentGateway\\": "packages/Custom/PaymentGateway/src/"
        }
    }
}
```

4. Run `composer dump-autoload`

## Configuration

Add the following environment variables to your `.env` file:

```env
PAYMENT_GATEWAY_NAME="Custom Gateway"
PAYMENT_GATEWAY_ENABLED=true
PAYMENT_GATEWAY_API_KEY=your_api_key
PAYMENT_GATEWAY_API_SECRET=your_api_secret
PAYMENT_GATEWAY_SANDBOX=true
PAYMENT_GATEWAY_WEBHOOK_URL=https://your-domain.com/payment-gateway/callback
```

## Usage

Visit `/payment-gateway` to access the payment gateway interface.

## Development

This package follows the standard Laravel package structure and can be extended as needed. 