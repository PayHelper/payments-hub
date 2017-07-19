# Public API

# Payment Gateways

These endpoints will allow you to get a list of available payment gateways.

Currently, there are three payment gateways configured:

- PayPal Express Checkout
- Stripe Checkout
- Offline

## List all payment gateways

> Definition

```shell
GET https://localhost/public-api/v1/payment-gateways/
```

Returns a list of all payment gateways.

> Example Request

```shell
curl -X GET \
  http://localhost/public-api/v1/payment-gateways/ \
  -H 'content-type: application/json'
```

> Example Response (200)

```json
{
    "offline": "Offline",
    "paypal_express_checkout": "PayPal Express Checkout",
    "stripe_checkout": "Stripe Checkout"
}
```
