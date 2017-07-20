# Orders

These endpoints will allow you to place a new order.

Thanks to this API you are able to place new orders.
Based on an order you can perform checkouts (see [Checkouts API](#checkouts11)).

## The order object

> Example Response

```json
{
    "id": 6,
    "checkout_completed_at": null,
    "number": null,
    "notes": null,
    "items": [
        {
            "id": 6,
            "quantity": 1,
            "unit_price": 500,
            "total": 500,
            "subscription": {
                "id": 6,
                "amount": "500",
                "currency_code": "PLN",
                "interval": "month",
                "name": "Monthly subscription",
                "code": "monthly_subscription",
                "created_at": "2017-07-06T12:13:46+0200",
                "updated_at": "2017-07-06T12:13:47+0200"
            },
            "_links": {
                "order": {
                    "href": "/api/v1/orders/6"
                }
            }
        }
    ],
    "items_total": 500,
    "total": 500,
    "state": "cart",
    "created_at": "2017-07-06T12:13:46+0200",
    "updated_at": "2017-07-06T12:13:47+0200",
    "payments": [],
    "checkout_state": "cart",
    "payment_state": "cart",
    "token_value": "WtR4aExE9C",
    "_links": {
        "self": {
            "href": "/api/v1/orders/6"
        }
    }
}
```

Field | Type | Description
--------- | ------- | -------
id | integer | Unique identifier for the object.
checkout_completed_at | string | Datetime when the checkout has been completed.
number | string | Order number, generated once the checkout is completed.
notes | string | Optional notes that can be added to an order when checkout is completed (see [Checkouts API](#complete-the-checkout)).
items | array | An array of order item objects.
items_total | int | A sum of all items prices.
total | int | A sum of items total and adjustments total.
state | string | A state of the order. Can be either: `cart`, `new`, `cancelled` or `fulfilled`.
created_at | string | Time at which the object was created.
updated_at | string | Time at which the object was updated.
payments | array | An array of Payment object which contains [payment methods](#payment-methods) objects.
checkout_state | string | A state of the checkout process. Can be either: `cart`, `payment_selected` or `completed`.
payment_state | string | A state of the payment. Can be either: `cart`, `new`, `processing`, `completed`, `failed`, `cancelled` or `refunded`.
token_value | string | A unique token that is used in payment process.

## Create an order

> Definition

```shell
POST https://localhost/public-api/v1/orders//
```

Creates a new order object in the system. If at least one payment method exists order object after creation will have one payment object assigned inside `payments` property which will contain default (the very first one defined in the system) payment method.

> Example Request

```shell
curl -X POST \
  http://localhost/public-api/v1/orders/ \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
  -d '{
      	"amount": 500,
      	"currency_code": "PLN",
      	"interval": "month",
      	"name": "Monthly subscription",
      	"code": "monthly_subscription"
}'
```

> Example Response (201 Created)

```json
{
    "id": 6,
    "checkout_completed_at": null,
    "number": null,
    "notes": null,
    "items": [
        {
            "id": 6,
            "quantity": 1,
            "unit_price": 500,
            "total": 500,
            "subscription": {
                "id": 6,
                "amount": "500",
                "currency_code": "PLN",
                "interval": "month",
                "name": "Monthly subscription",
                "code": "monthly_subscription",
                "created_at": "2017-07-06T12:13:46+0200",
                "updated_at": "2017-07-06T12:13:47+0200"
            },
            "_links": {
                "order": {
                    "href": "/api/v1/orders/6"
                }
            }
        }
    ],
    "items_total": 500,
    "total": 500,
    "state": "cart",
    "created_at": "2017-07-06T12:13:46+0200",
    "updated_at": "2017-07-06T12:13:47+0200",
    "payments": [],
    "checkout_state": "cart",
    "payment_state": "cart",
    "token_value": "WtR4aExE9C",
    "_links": {
        "self": {
            "href": "/api/v1/orders/6"
        }
    }
}
```

### Arguments

Name | Type | Description
--------- | ------- | -----------
amount <br>(`required`)| int | The amount of the order. It needs to be integer value, e.g. if `5 USD` will be given, it needs to be increased by a factor of `100` which will result in `500`.
currency_code <br>(`required`)| string | The valid currency code, e.g. USD, EUR, PLN.
name <br>(`required`)| string | Name of the order/subscription, to be displayed on invoices and in the web interface.
code <br>(`required`)| string | Code of the order/subscription, to be displayed on invoices and in the web interface.
interval <br>(`optional`)| string | One of `day`, `month` or `year`. The frequency with which a subscription should be billed. `month` by default.

### Returns

Returns order object if successfully created, and returns an error if something goes wrong.
