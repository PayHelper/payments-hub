# HUB API

# Payment Gateways

These endpoints will allow you to easily manage payment gateways.

Currently, there are five payment gateways configured:

- [Mollie](https://www.mollie.com/en/)
- [Mbe4](http://www.mbe4.de/)
- [PayPal Express Checkout](https://www.paypal.com/us/webapps/mpp/express-checkout)
- [Stripe Checkout](https://stripe.com/checkout)
- Offline

## List all payment gateways

> Definition

```shell
GET https://localhost/api/v1/payment-gateways/
```

Returns a list of all payment gateways.

> Example Request

```shell
curl -X GET \
  http://localhost/api/v1/payment-gateways/ \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json'
```

> Example Response (200)

```json
{
    "mbe4": "Mbe4",
    "mollie": "Mollie",
    "offline": "Offline",
    "paypal_express_checkout": "PayPal Express Checkout",
    "stripe_checkout": "Stripe Checkout"
}
```
