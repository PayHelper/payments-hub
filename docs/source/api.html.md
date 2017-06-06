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

Welcome to the Payments Hub API! You can use our API to access Payments Hub API endpoints, which can get information on various payments, payment methods, orders etc. in our database.

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
