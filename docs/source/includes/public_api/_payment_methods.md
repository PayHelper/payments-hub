# Payment Methods

These endpoints will allow you to list available payment methods.

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
      "href":"/public-api/v1/payment-methods/paypal"
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

## List all payment methods

> Definition

```shell
GET https://localhost/public-api/v1/payment-methods/
```

Returns a list of all payment methods. The payment methods are returned sorted by position, with the lowest payment method priority appearing first.

> Example Request

```shell
curl -X GET \
  http://localhost/public-api/v1/payment-methods/ \
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
      "href": "/public-api/v1/payment-methods/?page=1&limit=10"
    },
    "first": {
      "href": "/public-api/v1/payment-methods/?page=1&limit=10"
    },
    "last": {
      "href": "/public-api/v1/payment-methods/?page=1&limit=10"
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
            "href":"/public-api/v1/payment-methods/paypal"
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
