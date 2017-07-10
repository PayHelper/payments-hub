# Payment Methods

These endpoints will allow you to easily manage payment methods.

## The payment method object

> Example Response

```json
{
  "id":1,
  "code":"paypal",
  "position":1,
  "created_at":"2017-06-23T14:05:23+0200",
  "updated_at":"2017-06-23T14:05:23+0200",
  "enabled":true,
  "translations":{
    "en":{
      "locale":"en",
      "translatable":null,
      "id":1,
      "name":"PayPal",
      "description":"My method description",
      "instructions":"My method instructions"
    }
  },
  "gateway_config":{
    "factory_name":"paypal_express_checkout",
    "gateway_name":"PayPal",
    "config":{
      "username":"seller_api1.example.com",
      "password":"LW7Q8UXX3XF6AOP7",
      "signature":"DFcWxV21CUfd0v3bYYYRCpSSRl31RfQ6U98ckLkwqzodglNBGgBof5sK",
      "sandbox":true
    },
    "decrypted_config":null,
    "id":1
  },
  "_links":{
    "self":{
      "href":"/api/v1/payment-methods/paypal"
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
translations.en | array | Translation key (e.g. `en`).
translations.en.locale | string | Translation locale (e.g. `en`).
translations.en.translatable | object | Translatable object.
translations.en.id | integer | Unique identifier of the translation
translations.en.name | string | Translated name
translations.en.description | string | Translated description
translations.en.instructions | string | Translated instructions
gateway_config | object | Gateway configuration
gateway_config.factory_name | string | Gateway factory name (e.g. `offline`, see [Payment Gateways API](#payment-gateways))
gateway_config.gateway_name | string | Gateway name
gateway_config.config | object | Gateway specific configuration
gateway_config.decrypted_config | object | Gateway specific decrypted configuration
gateway_config.id | integer | Gateway configuration unique identifier

## Create a payment method

> Definition

```shell
POST https://localhost/api/v1/payment-methods/new/{paymentGateway}
```

Creates a new payment method object. In the example the PayPal Express Checkout method is created.

> Example Request

```shell
curl -X POST \
  http://localhost/api/v1/payment-methods/new/paypal_express_checkout \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
  -d '{
        "code":"paypal",
        "position":"1",
        "enabled":"1",
        "gateway_config":{
          "config":{
            "username":"seller_api1.example.com",
            "password":"LW7Q8UXX3XF6AOP7",
            "signature":"DFcWxV21CUfd0v3bYYYRCpSSRl31RfQ6U98ckLkwqzodglNBGgBof5sK",
            "sandbox":"1"
          }
        },
        "translations":{
          "en":{
            "name":"PayPal",
            "description":"My method description",
            "instructions":"My method instructions"
          }
        }
      }'
```

> Example Response (201 Created)

```json
{
  "id":1,
  "code":"paypal",
  "position":1,
  "created_at":"2017-06-23T14:05:23+0200",
  "updated_at":"2017-06-23T14:05:23+0200",
  "enabled":true,
  "translations":{
    "en":{
      "locale":"en",
      "translatable":null,
      "id":1,
      "name":"PayPal",
      "description":"My method description",
      "instructions":"My method instructions"
    }
  },
  "gateway_config":{
    "factory_name":"paypal_express_checkout",
    "gateway_name":"PayPal",
    "config":{
      "username":"seller_api1.example.com",
      "password":"LW7Q8UXX3XF6AOP7",
      "signature":"DFcWxV21CUfd0v3bYYYRCpSSRl31RfQ6U98ckLkwqzodglNBGgBof5sK",
      "sandbox":true
    },
    "decrypted_config":null,
    "id":1
  },
  "_links":{
    "self":{
      "href":"/api/v1/payment-methods/paypal"
    }
  }
}
```

### Arguments

Argument | Type |Default | Description
--------- | ------- | ------- | -----------
paymentGateway <br> (`required`) | string | N/A | Payment Gateway name (e.g. `offline`, `paypal_express_checkout`, can be retrieved from [Payment Gateways API](#payment-gateways))
code <br> (`required`) | string | N/A | An arbitrary string that you can attach to a payment method object. It is displayed alongside the payment method when listing all payment methods.
position <br> (`optional`) | integer | 0 | If set to 1, the payment method will be positioned at position 1 in the list of payment methods.
enabled <br> (`optional`) | boolean | true | If set to false, the payment method will be disabled else enabled.

## Retrieve a payment method

> Definition

```shell
GET http://localhost/api/v1/payment-methods/{code}
```

Retrieves the details of an existing payment method. You need only supply the unique payment method code that was typed upon payment method creation.

> Example Request

```shell
curl -X GET \
  http://localhost/api/v1/payment-methods/paypal \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
```

> Example Response (200)

```json
{
  "id":1,
  "code":"paypal",
  "position":1,
  "created_at":"2017-06-23T14:05:23+0200",
  "updated_at":"2017-06-23T14:05:23+0200",
  "enabled":true,
  "translations":{
    "en":{
      "locale":"en",
      "translatable":null,
      "id":1,
      "name":"PayPal",
      "description":"My method description",
      "instructions":"My method instructions"
    }
  },
  "gateway_config":{
    "factory_name":"paypal_express_checkout",
    "gateway_name":"PayPal",
    "config":{
      "username":"seller_api1.example.com",
      "password":"LW7Q8UXX3XF6AOP7",
      "signature":"DFcWxV21CUfd0v3bYYYRCpSSRl31RfQ6U98ckLkwqzodglNBGgBof5sK",
      "sandbox":true
    },
    "decrypted_config":null,
    "id":1
  },
  "_links":{
    "self":{
      "href":"/api/v1/payment-methods/paypal"
    }
  }
}
````

### Arguments

Name | Type | Description
--------- | ------- | -----------
code \(`required`)| string | Client facing payment method code

### Returns

Returns a payment method object if a valid code was provided.

## Update a payment method

> Definition

```shell
PATCH https://localhost/api/v1/payment-methods/{code}
```

Updates already existing payment method object.

> Example Request

```shell
curl -X PATCH \
  http://localhost/api/v1/payment-methods/new/paypal_express_checkout \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
  -d '{
        "code":"paypal",
        "position":"1",
        "enabled":"1",
        "gateway_config":{
          "config":{
            "username":"seller_api1.example.com",
            "password":"LW7Q8UXX3XF6AOP7",
            "signature":"DFcWxV21CUfd0v3bYYYRCpSSRl31RfQ6U98ckLkwqzodglNBGgBof5sK",
            "sandbox":"1"
          }
        },
        "translations":{
          "en":{
            "name":"PayPal",
            "description":"My method description",
            "instructions":"My method instructions"
          }
        }
      }'
```

> Example Response (204 No Content)

### Arguments

Argument | Type |Default | Description
--------- | ------- | ------- | -----------
paymentGateway <br> (`required`) | string | N/A | Payment Gateway name (e.g. `offline`, `paypal_express_checkout`, can be retrieved from [Payment Gateways API](#payment-gateways))
code <br> (`required`) | string | N/A | An arbitrary string that you can attach to a payment method object. It is displayed alongside the payment method when listing all payment methods.
position <br> (`optional`) | integer | 0 | If set to 1, the payment method will be positioned at position 1 in the list of payment methods.
enabled <br> (`optional`) | boolean | true | If set to false, the payment method will be disabled else enabled.

### Returns

Returns the empty response if the update succeeded with status code 204 No Content. Returns an error if update parameters are invalid (e.g. invalid code, translation etc.).

## List all payment methods

> Definition

```shell
GET https://localhost/api/v1/payment-methods/
```

Returns a list of all payment methods. The payment methods are returned sorted by position, with the lowest payment method priority appearing first.

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
        "id":1,
        "code":"paypal",
        "position":1,
        "created_at":"2017-06-23T14:05:23+0200",
        "updated_at":"2017-06-23T14:05:23+0200",
        "enabled":true,
        "translations":{
          "en":{
            "locale":"en",
            "translatable":null,
            "id":1,
            "name":"PayPal",
            "description":"My method description",
            "instructions":"My method instructions"
          }
        },
        "gateway_config":{
          "factory_name":"paypal_express_checkout",
          "gateway_name":"PayPal",
          "config":{
            "username":"seller_api1.example.com",
            "password":"LW7Q8UXX3XF6AOP7",
            "signature":"DFcWxV21CUfd0v3bYYYRCpSSRl31RfQ6U98ckLkwqzodglNBGgBof5sK",
            "sandbox":true
          },
          "decrypted_config":null,
          "id":1
        },
        "_links":{
          "self":{
            "href":"/api/v1/payment-methods/paypal"
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

A dictionary with a `items` property that contains an array of up to `limit` payment methods. Each entry in the array is a separate payment method object. If no more payment methods are available, the resulting array will be empty. This request should never return an error.
