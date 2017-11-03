# Subscriptions

These endpoints will allow you to create new recurring or non-recurring subscriptions and will allow to pay for the created subscription.

Based on created subscriptions you can perform purchases (see [Purchase API](#purchase)).

## The subscription object

> Example Response

```json
{
    "id": 79,
    "amount": 500,
    "currency_code": "USD",
    "interval": "1 month",
    "start_date": "2017-10-10T00:00:00+00:00",
    "type": "recurring",
    "items": [
        {
            "id": 46,
            "quantity": 1,
            "unit_price": 500,
            "total": 500
        }
    ],
    "purchase_completed_at": "2017-10-10T14:54:53+00:00",
    "items_total": 500,
    "total": 500,
    "state": "new",
    "created_at": "2017-10-10T14:54:53+00:00",
    "updated_at": "2017-10-10T14:54:53+00:00",
    "payments": [],
    "purchase_state": "completed",
    "payment_state": "awaiting_payment",
    "token_value": "zadfgN_3Oo",
    "method": {
        "id": 1,
        "code": "directdebit",
        "position": 1,
        "created_at": "2017-10-25T14:45:01+00:00",
        "updated_at": "2017-10-25T14:45:01+00:00",
        "enabled": true,
        "translations": {
            "en": {
                "locale": "en",
                "translatable": null,
                "id": 1,
                "name": "SEPA Direct Debit",
                "description": "My method description",
                "instructions": "My method instructions"
            }
        },
        "supports_recurring": true,
        "_links": {
            "self": {
                "href": "/api/v1/payment-methods/directdebit_oneoff"
            }
        }
    }
}
```

Field | Type | Description
--------- | ------- | -------
id | integer | Unique identifier for the object.
purchase_completed_at | string | Datetime when the purchase has been completed.
amount | int | The amount of the subscription. It needs to be integer value, e.g. if `5` will be given, it needs to be increased by a factor of `100` which will result in `500`. The value can't be lower than `500`.
currency_code| string | Three-letter ISO code for currency, e.g. USD, EUR, PLN.
interval <br>(`optional`)| string | One of `3 months`, `1 month` or `1 year`. The frequency with which a subscription should be billed. `1 month` by default.
type | string | Subscription type (either `recurring` or `non-recurring`).
start_date | string | Subscription start date, applies only for recurring subscriptions.
items | array | An array of subscription items. For more complex subscriptions handling.
items_total | int | A sum of all items prices.
total | int | A sum of items total.
state | string | A state of the subscription. Can be either: `new`, `cancelled` or `fulfilled`.
created_at | string | Time at which the object was created.
updated_at | string | Time at which the object was updated.
payments | array | An array of Payment object which contains [payment methods](#payment-methods) objects.
purchase_state | string | A state of the purchase process. Can be either: `new`, `payment_selected` or `completed`.
payment_state | string | A state of the payment. Can be either: `new`, `processing`, `completed`, `failed`, `cancelled` or `refunded`.
token_value | string | A unique token that is used in payment process.
method | object | A subscription's payment method object. Defines which payment method has been selected to pay for the subscription (see [Payment Methods API](#payment-methods)).

## Create a subscription

> Definition

```shell
POST https://localhost/public-api/v1/subscriptions/
```

Creates a new subscription object in the system. If at least one payment method exists, a subscription object after the creation will have one payment object assigned inside `payments` property which will contain default (the very first one defined in the system) payment method.

> Example Request

```shell
curl -X POST \
  http://localhost/public-api/v1/subscriptions/ \
  -H 'content-type: application/json' \
  -d '{
      	"amount": 500,
      	"currency_code": "USD",
      	"interval": "1 month",
      	"type": "recurring",
      	"start_date": {
      	    "day": "10",
      	    "month": "10",
      	    "year": "2017"
      	},
      	"method": "directdebit"
}'
```

> Example Response (201 Created)

```json
{
    "id": 79,
    "amount": 500,
    "currency_code": "USD",
    "interval": "1 month",
    "start_date": "2017-10-10T00:00:00+00:00",
    "type": "recurring",
    "items": [
        {
            "id": 46,
            "quantity": 1,
            "unit_price": 500,
            "total": 500
        }
    ],
    "purchase_completed_at": "2017-10-10T14:54:53+00:00",
    "items_total": 500,
    "total": 500,
    "state": "new",
    "created_at": "2017-10-10T14:54:53+00:00",
    "updated_at": "2017-10-10T14:54:53+00:00",
    "payments": [],
    "purchase_state": "completed",
    "payment_state": "awaiting_payment",
    "token_value": "zadfgN_3Oo",
    "method": {
        "id": 1,
        "code": "directdebit",
        "position": 1,
        "translations": {
            "en": {
                "locale": "en",
                "translatable": null,
                "id": 1,
                "name": "SEPA Direct Debit",
                "description": "My method description",
                "instructions": "My method instructions"
            }
        },
        "supports_recurring": true,
        "_links": {
            "self": {
                "href": "/api/v1/payment-methods/directdebit_oneoff"
            }
        }
    }
}
```

### Arguments

Name | Type | Description
--------- | ------- | -----------
amount <br>(`required`)| int | The amount of the subscription. It needs to be integer value, e.g. if `5 USD` will be given, it needs to be increased by a factor of `100` which will result in `500`. The value can't be lower than `500`.
currency_code <br>(`required`)| string | The valid currency code, e.g. USD, EUR, PLN.
interval <br>(`optional`)| string | One of `3 months`, `1 month` or `1 year`. The frequency with which a subscription should be billed. `1 month` by default.
type <br>(`required`)| string | Subscription type (either `recurring` or `non-recurring`).
start_date <br>(`required`)| string | Subscription start date, by default current date, applies only for recurring subscriptions.

### Returns

Returns subscription object if successfully created, and returns an error if something goes wrong.

## Pay for a subscription

> Definition

```shell
GET http://localhost/public-api/v1/subscriptions/{tokenValue}/pay/
```

Calling this endpoint will automatically prepare capture and redirect to a proper payment gateway that was selected during the subscription creation (see [Create a Subscription API Endpoint](#create-a-subscription35)) in order to pay for a subscription (e.g. when a PayPal payment method is selected and this endpoint will be called, the app will perform a redirect to a PayPal page to pay for the subscription and if the payment succeeded or failed it will redirect to `thank you` page).

Once the payment transaction is finalized successfully the subscription state is changed from `new` to `fullfiled` and the subscription's payment state is changed from `awaiting_payment` to `paid`.

> Example Request

```shell
curl -X GET \
  http://localhost/public-api/v1/subscriptions/lKD1QhGtjW/pay/ \
  -H 'content-type: application/json' \
```

> Response (302)

### Arguments

Name | Type | Description
--------- | ------- | -----------
tokenValue \(`required`)| string | The token value of the subscription to be paid (can be retrieved from Subscriptions API). It is generated once the subscription is created.

### Returns

Returns an empty response with status code 302 if payment capture succeeded. Returns an error otherwise.
