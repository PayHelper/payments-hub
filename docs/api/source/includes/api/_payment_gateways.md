# HUB API

# Payment Gateways

These endpoints will allow you to easily manage payment gateways.

Currently, there are five payment gateways configured:

- [Mollie](https://www.mollie.com/en/)
- [Mbe4](http://www.mbe4.de/)
- [PayPal Express Checkout](https://www.paypal.com/us/webapps/mpp/express-checkout)
- [Stripe Checkout](https://stripe.com/checkout)
- Offline

[This list](https://github.com/PayHelper/payments-hub/blob/master/features/api/payments/adding_new_payment_method.feature)
shows how to create different payment methods based on available gateways and their configs.

For example, you can create recurring SEPA Direct Debit payments, one-off SEPA Direct Debits payments, credit card payments etc.

## Gateways configuration

- **Mollie**

Config | Type |Default | Description
--------- | ------- | ------- | -----------
method <br> (`required`) | string | N/A | Mollie gateway method. Possible values: `directdebit` (for recurring SEPA Direct Debit payments), `creditcard` (for credit card payments), `directdebit_oneoff` (for one-off SEPA Direct Debit payments).
apiKey <br> (`required`) | string | N/A | Mollie API key.
minAmount <br> (`optional`) | integer | null | Minimum amount which can be handled by this payment gateway. If set to `100`, a minimum value of `100` needs to be provided in the subscription's amount field.
maxAmount <br> (`optional`) | integer | null | Maximum amount which can be handled by this payment gateway. If set to `100`, a maximum value of `100` needs to be provided in the subscription's amount field.

- **Mbe4**

Config | Type |Default | Description
--------- | ------- | ------- | -----------
username <br> (`required`) | string | N/A | Mbe4 gateway username. 
password <br> (`required`) | string | N/A | Mbe4 gateway password.
clientId <br> (`required`) | string | N/A | Mbe4 gateway client identifier.
serviceId <br> (`required`) | string | N/A | Mbe4 gateway service identifier.
contentclass <br> (`required`) | integer | N/A | Mbe4 gateway contentclass identifier.
minAmount <br> (`optional`) | integer | null | Minimum amount which can be handled by this payment gateway. If set to `100`, a minimum value of `100` needs to be provided in the subscription's amount field.
maxAmount <br> (`optional`) | integer | null | Maximum amount which can be handled by this payment gateway. If set to `100`, a maximum value of `100` needs to be provided in the subscription's amount field.

- **PayPal Express Checkout**

Config | Type |Default | Description
--------- | ------- | ------- | -----------
username <br> (`required`) | string | N/A | PayPal's account username, if `sandbox` field is set to `true`, it requires PayPal Sandbox account username.
password <br> (`required`) | string | N/A | PayPal's account password, if `sandbox` field is set to `true`, it requires PayPal Sandbox account password.
signature <br> (`required`) | string | N/A | PayPal's account signature, if `sandbox` field is set to `true`, it requires PayPal Sandbox account signature.
sandbox <br> (`required`) | boolean | N/A | Either it should use sandbox service or not.
minAmount <br> (`optional`) | integer | null | Minimum amount which can be handled by this payment gateway. If set to `100`, a minimum value of `100` needs to be provided in the subscription's amount field.
maxAmount <br> (`optional`) | integer | null | Maximum amount which can be handled by this payment gateway. If set to `100`, a maximum value of `100` needs to be provided in the subscription's amount field.


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
