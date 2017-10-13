# Subscriptions

These endpoints will allow you to create new recurring or non-recurring subscriptions.

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
    "purchase_completed_at": null,
    "items_total": 500,
    "total": 500,
    "state": "new",
    "created_at": "2017-10-10T14:54:53+00:00",
    "updated_at": "2017-10-10T14:54:53+00:00",
    "payments": [],
    "purchase_state": "new",
    "payment_state": "new",
    "token_value": "zadfgN_3Oo"
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
purchase_state | string | A state of the checkout process. Can be either: `new`, `payment_selected` or `completed`.
payment_state | string | A state of the payment. Can be either: `new`, `processing`, `completed`, `failed`, `cancelled` or `refunded`.
token_value | string | A unique token that is used in payment process.

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
      	    "month: "10",
      	    "year": "2017"
      	}
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
    "purchase_completed_at": null,
    "items_total": 500,
    "total": 500,
    "state": "new",
    "created_at": "2017-10-10T14:54:53+00:00",
    "updated_at": "2017-10-10T14:54:53+00:00",
    "payments": [],
    "purchase_state": "new",
    "payment_state": "new",
    "token_value": "zadfgN_3Oo"
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
