---
title: API Reference

language_tabs:
  - shell: cURL

toc_footers:
  - <a href='https://github.com/tripit/slate'>Documentation Powered by Slate</a>

includes:
  - errors

search: true
---

# Introduction

Welcome to the Payments Hub API! You can use our API to access Payments Hub API endpoints, which can get information on various payments, payment methods, orders checkouts etc. in our database.

We have language bindings in Shell! You can view code examples in the dark area to the right, and you can switch the programming language of the examples with the tabs in the top right.

# Authentication

> To authorize, use this code:

```shell
# With shell, you can just pass the correct header with each request
curl "api_endpoint_here"
  -H "Authorization: key"
```

> Make sure to replace `key` with your API key.

TODO...

# Payment Methods

These endpoints will allow you to easily manage payment methods

## The payment method object

The payment method object description.

> Example Response

```json
{
  "id": 1,
  "code": "cash_on_delivery",
  "position": 1,
  "created_at": "2017-06-06T14:49:08+0200",
  "updated_at": null,
  "enabled": true,
  "translations": {
    "en": {
      "locale": "en",
      "translatable": null,
      "id": 1,
      "name": "offline",
      "description": "My cash on delivery method",
      "instructions": "Some instructions about that method"
    }
  },
  "gateway_config": {
    "factory_name": "offline",
    "gateway_name": "offline",
    "config": [],
    "decrypted_config": [],
    "id": 1
  },
  "_links": {
    "self": {
      "href": "/api/v1/payment-methods/cash_on_delivery"
    }
  }
}
```

Field | Type | Description
--------- | ------- | -------
id | integer | Unique identifier for the object.
code | string | Client facing order code
position | integer | Position of payment method.
created_at | string | Time at which the object was created.
updated_at | string | Time at which the object was updated.
enabled | boolean | This boolean represents whether or not payment method is enabled or not.
translations | array | Translations.

TODO...

## Create a payment method

Creates a new payment method object.

> Definition

```shell
POST https://localhost/api/v1/payment-methods/
```

> Example Request

```shell
curl -X POST \
  http://localhost/api/v1/payment-methods/new/offline \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
  -d '{
    "code": "cash_on_delivery",
    "position": "1",
    "enabled": "1",
    "translations": {
        "en": {
            "name": "offline",
            "description": "My cash on delivery method",
            "instructions": "Some instructions about that method"
        }
    }
}'
```

> Example Response

```json
{
  "id": 1,
  "code": "cash_on_delivery",
  "position": 1,
  "created_at": "2017-06-06T14:49:08+0200",
  "updated_at": null,
  "enabled": true,
  "translations": {
    "en": {
      "locale": "en",
      "translatable": null,
      "id": 1,
      "name": "offline",
      "description": "My cash on delivery method",
      "instructions": "Some instructions about that method"
    }
  },
  "gateway_config": {
    "factory_name": "offline",
    "gateway_name": "offline",
    "config": [],
    "decrypted_config": [],
    "id": 1
  },
  "_links": {
    "self": {
      "href": "/api/v1/payment-methods/cash_on_delivery"
    }
  }
}
```

### Arguments

Argument | Default | Description
--------- | ------- | -----------
code | null | An arbitrary string that you can attach to a payment method object. It is displayed alongside the payment method when listing all payment methods.
position | 0 | If set to 1, the payment method will be positioned at position 1 in the list of payment methods.
enabled | true | If set to false, the payment method will be disabled else enabled.
translations | true | If set to false, the payment method will be disabled else enabled.

## Retrieve a payment method

## Update a payment method

## List all payment methods

Returns a list of all payment methods. The payment methods are returned sorted by position, with the lowest payment method priority appearing first.

> Definition

```shell
POST https://localhost/api/v1/payment-methods/
```

### Arguments

Argument | Default | Description
--------- | ------- | -----------
limit | 10 | A limit on the number of objects to be returned.
page | 1 | A page number

> Example Request

```shell
curl -X GET \
  http://localhost/api/v1/payment-methods/ \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json'
```

> Example Response

```json
{
  "page": 1,
  "limit": 10,
  "pages": 1,
  "total": 1,
  "_links": {
    "self": {
      "href": "/api/v1/payment-methods/?page=1&limit=10"
    },
    "first": {
      "href": "/api/v1/payment-methods/?page=1&limit=10"
    },
    "last": {
      "href": "/api/v1/payment-methods/?page=1&limit=10"
    }
  },
  "_embedded": {
    "items": [
      {
        "id": 1,
        "code": "cash_on_delivery",
        "position": 1,
        "translations": {
          "en": {
            "locale": "en",
            "translatable": null,
            "id": 1,
            "name": "offline",
            "description": "My cash on delivery method",
            "instructions": "Some instructions about that method"
          }
        },
        "gateway_config": {
          "factory_name": "offline",
          "gateway_name": "offline",
          "config": [],
          "decrypted_config": null,
          "id": 1
        },
        "_links": {
          "self": {
            "href": "/api/v1/payment-methods/cash_on_delivery"
          }
        }
      }
    ]
  }
}
```

# Checkouts

These endpoints will allow you to easily go through the order checkout process resulting in paying for order and finalizing the checkout.

The checkout can be performed only when there is an order created.

Checkouts API consists of three steps which must be executed in the exact order, unless you customize it:

1. Select a payment method
2. Complete the checkout
3. Pay for an order

## Select a payment method

> Definition

```shell
PATCH https://localhost/api/v1/checkouts/payment/{orderId}
```

This endpoint allows to select one of the payment methods which exists in the system and assign it to the order.

For example, if you have placed a new order and you want to pay for it, you can choose whether you want to pay using PayPal or offline etc.

Once the payment method is selected, the state of an order will change from `cart` to `new`, the checkout state of an order will change from `cart` to `payment_selected` and the order payment state will change from state `cart` to `awaiting_payment`.

**Note:** You can check the [configuration](https://github.com/sourcefabric/payments-hub/blob/master/src/PH/Bundle/CoreBundle/Resources/config/app/state_machine/ph_order_checkout.yml) of the state machine to see the configured states and transitions.

> Example Request

```shell
curl -X PATCH \
  http://localhost/api/v1/checkouts/payment/1 \
  -H 'accept: application/json' \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
  -d '{
  "payments":[
    {
      "method":"paypal"
    }
  ]
}'
```

**Hint:** The `PUT` method is also supported by this endpoint.

> Response (204 No Content)

### Returns 

Returns an empty response if selecting payment method succeeded. Returns an error if selecting payment method can not be done (e.g. when the selected payment method does not exist or an order does not exist).

## Complete the checkout

> Definition

```shell
PUT https://localhost/api/v1/checkouts/complete/{orderId}
```

Here, after the payment method is selected, you can complete the order checkout to be able to pay for an order using the previously selected payment method.

Once this endpoint is called, the order checkout state will change from `payment_selected` to `completed` and order payment state will change from `cart` to `awaiting_payment`.

**Note:** You can check the [configuration](https://github.com/sourcefabric/payments-hub/blob/master/src/PH/Bundle/CoreBundle/Resources/config/app/state_machine/ph_order_checkout.yml) of the state machine to see the configured states and transitions.

> Example Request

```shell
curl -X PUT \
  http://localhost/api/v1/checkouts/complete/1 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
  -d '{
  "notes": "Thanks for your great content!"
}'
```

> Response (204 No Content)

### Arguments

Name | Type | Description
--------- | ------- | -----------
orderId (`required`)| integer | The identifier of the order to be completed.
notes (`optional`)| string | An extra notes.

### Returns 

Returns an empty response if checkout complete succeeded. Returns an error if complete can not be done (e.g. when the payment method is not selected).

## Pay for an order

> Definition

```shell
GET http://localhost/api/v1/checkouts/pay/{tokenValue}
```

Calling this endpoint will automatically prepare capture and redirect to a proper payment gateway that was selected during the checkout in order to pay for an order (e.g. when a PayPal payment method is selected for an order and this endpoint will be called, it will perform a redirect to a PayPal page to pay for the goods and if the payment succeeded or failed it will redirect to `thank you` endpoint which will return no content but a proper status code.)

Once the payment transaction is finalized successfully the order state is changed from `new` to `fullfiled` and the order payment state is changed from `awaiting_payment` to `paid`.

> Example Request

```shell
curl -X GET \
  http://localhost/api/v1/checkouts/pay/z~ADQ18G~3 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
```

> Response (204 No Content)

### Arguments

Name | Type | Description
--------- | ------- | -----------
tokenValue \(`required`)| string | The token value of the order to be paid (can be retrieved from Orders API). It is generated once the checkout is completed.

### Returns

Returns an empty response if checkout payment capture succeeded. Returns an error if complete can not be done.
