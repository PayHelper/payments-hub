# Subscriptions

These endpoints allow you to easily manage subscriptions.

Based on created subscriptions you can perform purchases (see [Purchase API](#purchase-api)).

## The subscription object

> Example Response

```json
{
    "id": 79,
    "amount": 500,
    "currency_code": "USD",
    "interval": "1 month",
    "start_date": "2017-10-15T00:00:00+00:00",
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
        "gateway_config": {
            "factory_name": "mollie",
            "gateway_name": "mollie_sepa_direct_debit",
            "config": {
                "apiKey": "test_6tPGmmxNg9AEgxWc7um8E5qEyc97rm",
                "method": "directdebit",
                "minAmount": 600,
                "maxAmount": 1500
            },
            "decrypted_config": null,
            "id": 1
        },
        "supports_recurring": false,
        "_links": {
            "self": {
                "href": "/api/v1/payment-methods/directdebit_oneoff"
            }
        }
    },
    "metadata": {}
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
start_date | string | Subscription start date applies only to recurring subscriptions. Possible values are the 1st day of the current month and year, the 15th day of the current month and year, the 1st day of the next month and current year, the 15th day of the next month and current year. If the current date is lower than the one picked from the dates mentioned above, the API will return 400 status code.
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
method | object | A subscription's payment method object. Defines which payment method has been selected to pay for the subscription (see [Payment Methods API](#payment-methods)).
metadata | object | Set of key/value pairs that you can attach to an object. It can be useful for storing additional information about the object in a structured format.

## Create a subscription

> Definition

```shell
POST https://localhost/public-api/v1/subscriptions/
```

Creates a new subscription object in the system. If at least one payment method exists, a subscription object after the creation will have one payment object assigned inside `payments` property which will contain the selected payment method.

> Example Request

```shell
curl -X POST \
  http://localhost/api/v1/subscriptions/ \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
  -d '{
      	"amount": 500,
      	"currency_code": "USD",
      	"interval": "1 month",
      	"type": "recurring",
      	"start_date": "2017-10-15",
      	"method": "directdebit",
        "metadata": {
        	"intention": "bottom_box",
        	"source": "web_version"
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
    "start_date": "2017-10-15T00:00:00+00:00",
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
        "gateway_config": {
            "factory_name": "mollie",
            "gateway_name": "mollie_sepa_direct_debit",
            "config": {
                "apiKey": "test_6tPGmmxNg9AEgxWc7um8E5qEyc97rm",
                "method": "directdebit",
                "minAmount": 600,
                "maxAmount": 1500
            },
            "decrypted_config": null,
            "id": 1
        },
        "supports_recurring": false,
        "_links": {
            "self": {
                "href": "/api/v1/payment-methods/directdebit_oneoff"
            }
        },
    },
    "metadata": {
        "intention": "bottom_box",
        "source": "web_version"
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
start_date <br>(`required`)| string | Subscription start date applies only to recurring subscriptions. Possible values are the 1st day of the current month and year, the 15th day of the current month and year, the 1st day of the next month and current year, the 15th day of the next month and current year. If the current date is lower than the one picked from the dates mentioned above, the API will return 400 status code.
.method <br>(`required`)| string | Subscription's payment method. A value of payment method's code must be used here, e.g. `directdebit` (see [Payment Methods API](#payment-methods)).
metadata <br>(`optional`)| object | Set of key/value pairs that you can attach to an object. It can be useful for storing additional information about the object in a structured format.


### Returns

Returns subscription object if successfully created, and returns an error if something goes wrong.

## Retrieve a subscription

> Definition

```shell
GET https://localhost/api/v1/subscriptions/{id}
```

Retrieves the details of an existing subscription. You need only supply the unique subscription identifier that was generated upon subscription creation.

> Example Request

```shell
curl -X GET \
  http://localhost/api/v1/subscriptions/79 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json'
```

> Example Response (200)

```json
{
    "id": 79,
    "amount": 500,
    "currency_code": "USD",
    "interval": "1 month",
    "start_date": "2017-10-15T00:00:00+00:00",
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
        "gateway_config": {
            "factory_name": "mollie",
            "gateway_name": "mollie_sepa_direct_debit",
            "config": {
                "apiKey": "test_6tPGmmxNg9AEgxWc7um8E5qEyc97rm",
                "method": "directdebit",
                "minAmount": 600,
                "maxAmount": 1500
            },
            "decrypted_config": null,
            "id": 1
        },
        "supports_recurring": false,
        "_links": {
            "self": {
                "href": "/api/v1/payment-methods/directdebit_oneoff"
            }
        }
    },
    "metadata": {
        "intention": "bottom_box",
        "source": "web_version"
    }
}
```

### Arguments

Name | Type | Description
--------- | ------- | -----------
id <br>(`required`)| string | The unique identifier of the subscription.

### Returns

Returns a subscription if a valid identifier was provided, and returns an error otherwise.

## Delete a subscription

> Definition

```shell
DELETE https://localhost/api/v1/subscriptions/{id}
```

Deletes the subscription object. You need only supply the unique subscription identifier that was generated upon subscription creation in order to remove an object.

> Example Request

```shell
curl -X DELETE \
  http://localhost/api/v1/subscriptions/79 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json'
```

> Example Response (204 No Content)

### Arguments

Name | Type | Description
--------- | ------- | -----------
id <br>(`required`)| string | The unique identifier of the subscription.

### Returns

Returns an empty response if deleting the subscription succeeded. Returns an error if deleting the subscription can not be done (e.g. when the subscription does not exist).

## Cancel a subscription's payment
> Definition

```shell
DELETE https://localhost/api/v1/subscriptions/{subscriptionId}/payments/{id}/cancel
```

Cancels an subscription's payment. You need only supply the unique subscription identifier that was generated upon subscription creation and payment id in order to cancel the subscription's payment.
If the payment is recurring, it will be canceled so that the customer won't be charged anymore.

> Example Request

```shell
curl -X DELETE \
  http://localhost/api/v1/subscriptions/79/payments/7/cancel \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json'
```

> Example Response (204 No Content)

### Arguments

Name | Type | Description
--------- | ------- | -----------
subscriptionId <br>(`required`)| string | The unique identifier of the subscription.
id <br>(`required`)| string | The unique identifier of an subscription's payment.

### Returns

Returns an empty response if cancelling the subscription's payment succeeded. Returns an error if cancelling subscription's payment can not be done (e.g. when subscription does not exist or when subscription is non-recurring).


## Complete a subscription's payment

> Definition

```shell
PUT https://localhost/api/v1/subscriptions/{id}/payments/{paymentId}/complete
```

Completes the subscription's payment. You need only supply the unique subscription identifier that was generated upon subscription creation and subscription's payment id in order to perform complete action.

Completing subscription payment is useful when for example, offline payment method is selected and once the seller receives the money from buyer, the subscription's payment can be completed manually and marked as paid.

> Example Request

```shell
curl -X PUT \
  http://localhost/api/v1/subscriptions/79/payments/1/complete \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json'
```

> Example Response (204 No Content)

### Arguments

Name | Type | Description
--------- | ------- | -----------
id <br>(`required`)| string | The unique identifier of the subscription.
paymentId <br>(`required`)| string | The unique identifier of the subscription's payment.

### Returns

Returns an empty response if completing subscription payment succeeded. Returns an error if completing subscription payment can not be done (e.g. when the subscription does not exist).

## List all subscriptions

> Definition

```shell
GET https://localhost/api/v1/subscriptions/
```

Returns a list of all subscriptions.

> Example Request

```shell
curl -X GET \
  https://localhost/api/v1/subscriptions/
   -H "Authorization: Bearer key"\
  -H 'content-type: application/json'
```

> Example Response (200)

```json
{
    "page": 1,
    "limit": 10,
    "pages": 1,
    "total": 1,
    "_links": {
        "self": {
            "href": "/api/v1/subscriptions/?page=1&limit=10"
        },
        "first": {
            "href": "/api/v1/subscriptions/?page=1&limit=10"
        },
        "last": {
            "href": "/api/v1/subscriptions/?page=1&limit=10"
        }
    },
    "_embedded": {
        "items": [
            {
                "id": 79,
                "amount": 500,
                "currency_code": "USD",
                "interval": "1 month",
                "start_date": "2017-10-15T00:00:00+00:00",
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
                    "gateway_config": {
                        "factory_name": "mollie",
                        "gateway_name": "mollie_sepa_direct_debit",
                        "config": {
                            "apiKey": "test_6tPGmmxNg9AEgxWc7um8E5qEyc97rm",
                            "method": "directdebit",
                            "minAmount": 600,
                            "maxAmount": 1500
                        },
                        "decrypted_config": null,
                        "id": 1
                    },
                    "supports_recurring": false,
                    "_links": {
                        "self": {
                            "href": "/api/v1/payment-methods/directdebit_oneoff"
                        }
                    }
                },
                "metadata": {
                    "intention": "bottom_box",
                    "source": "web_version"
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

A dictionary with a `items` property that contains an array of up to `limit` subscriptions. Each entry in the array is a separate subscription object. If no more subscriptions are available, the resulting array will be empty. This request should never return an error.
