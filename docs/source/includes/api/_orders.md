# Orders

These endpoints will allow you to easily manage orders.

Thanks to this API you are able to manage orders, you can place new orders, update it, delete it etc.
Based on an order you can perform checkouts (see [Checkouts API](#checkouts)).

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
POST https://localhost/api/v1/orders/create/
```

Creates a new order object in the system. If at least one payment method exists order object after creation will have one payment object assigned inside `payments` property which will contain default (the very first one defined in the system) payment method.

> Example Request

```shell
curl -X POST \
  http://localhost/api/v1/orders/create/ \
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

## Retrieve an order

> Definition

```shell
GET https://localhost/api/v1/orders/{id}
```

Retrieves the details of an existing order. You need only supply the unique order identifier that was generated upon order creation.

> Example Request

```shell
curl -X GET \
  http://localhost/api/v1/orders/6 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json'
```

> Example Response (200)

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
id <br>(`required`)| string | The unique identifier of an order.

### Returns

Returns a order if a valid identifier was provided, and returns an error otherwise.

## Delete an order

> Definition

```shell
DELETE https://localhost/api/v1/orders/{id}
```

Deletes an order object. You need only supply the unique order identifier that was generated upon order creation in order to remove an object.

> Example Request

```shell
curl -X DELETE \
  http://localhost/api/v1/orders/6 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json'
```

> Example Response (204 No Content)

### Arguments

Name | Type | Description
--------- | ------- | -----------
id <br>(`required`)| string | The unique identifier of an order.

### Returns

Returns an empty response if deleting an order succeeded. Returns an error if deleting order can not be done (e.g. when an order does not exist).

## List all orders

> Definition

```shell
GET https://localhost/api/v1/orders/
```

Returns a list of all orders.

> Example Request

```json
{
    "page": 1,
    "limit": 10,
    "pages": 1,
    "total": 1,
    "_links": {
        "self": {
            "href": "/api/v1/orders/?page=1&limit=10"
        },
        "first": {
            "href": "/api/v1/orders/?page=1&limit=10"
        },
        "last": {
            "href": "/api/v1/orders/?page=1&limit=10"
        }
    },
    "_embedded": {
        "items": [
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
        ]
    }
}
```

### Arguments

Argument | Default | Description
--------- | ------- | -----------
limit | 10 | A limit on the number of objects to be returned.
page | 1 | A page number

### Returns

A dictionary with a `items` property that contains an array of up to `limit` orders. Each entry in the array is a separate order object. If no more orders are available, the resulting array will be empty. This request should never return an error.
