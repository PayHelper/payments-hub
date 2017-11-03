# Public API

# Payment Gateways

These endpoints will allow you to get a list of available payment gateways.

Currently, there are five payment gateways configured:

- [Mollie](https://www.mollie.com/en/)
- [Mbe4](http://www.mbe4.de/)
- [PayPal Express Checkout](https://www.paypal.com/us/webapps/mpp/express-checkout)
- [Stripe Checkout](https://stripe.com/checkout)
- Offline

[This list](https://github.com/PayHelper/payments-hub/blob/master/features/api/payments/adding_new_payment_method.feature)
shows how to create different payment methods based on available gateways and their configs.

For example, you can create recurring SEPA Direct Debit payments, one-off SEPA Direct Debits payments, credit card payments etc.


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
    "mbe4": "Mbe4",
    "mollie": "Mollie",
    "offline": "Offline",
    "paypal_express_checkout": "PayPal Express Checkout",
    "stripe_checkout": "Stripe Checkout"
}
```
