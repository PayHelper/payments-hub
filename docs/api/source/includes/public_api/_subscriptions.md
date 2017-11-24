# Subscriptions

These endpoints will allow you to create new recurring or non-recurring subscriptions and will allow to pay for the created subscription.

Based on created subscriptions you can perform purchases (see [Purchase API](#purchase)).

## The subscription object

> Example Response

```json
{
    "amount": 500,
    "currency_code": "USD",
    "interval": "1 month",
    "start_date": "2017-10-15T00:00:00+00:00",
    "type": "recurring",
    "purchase_completed_at": "2017-11-06T14:14:41+00:00",
    "purchase_state": "completed",
    "payment_state": "awaiting_payment",
    "token_value": "GpEwIpL474",
    "method": {
        "code": "directdebit",
        "position":1,
        "supports_recurring":true,
        "translations": {
            "en": {
                "locale": "en",
                "translatable": null,
                "id": 3,
                "name": "SEPA Direct Debit",
                "description": "My method description",
                "instructions": "My method instructions"
            }
        }
    },
    "metadata": {
        "intention": "bottom_box",
        "source": "web_version"
    }
}
```

Field | Type | Description
--------- | ------- | -------
amount | int | The amount of the subscription. It needs to be integer value, e.g. if `5` will be given, it needs to be increased by a factor of `100` which will result in `500`. The amount's value can't be lower than the limit configured in payment method gateway's configuration.
currency_code| string | Three-letter ISO code for currency, e.g. USD, EUR, PLN.
interval <br>(`optional`)| string | One of `3 months`, `1 month` or `1 year`. The frequency with which a subscription should be billed. `1 month` by default.
type | string | Subscription type (either `recurring` or `non-recurring`).
start_date | string | Subscription start date applies only to recurring subscriptions. Possible values are the 1st day of the current month and year, the 15th day of the current month and year, the 1st day of the next month and current year, the 15th day of the next month and current year. If the current date is lower than the one picked from the dates mentioned above, the API will return 400 status code.
token_value | string | A unique token that is used in payment process.
purchase_state | string | A state of the checkout process. Can be either: `new`, `payment_selected` or `completed`.
payment_state | string | A state of the payment. Can be either: `new`, `processing`, `completed`, `failed`, `cancelled` or `refunded`.
purchase_completed_at | string | Datetime when the purchase has been completed.
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
  http://localhost/public-api/v1/subscriptions/ \
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
    "amount": 500,
    "currency_code": "USD",
    "interval": "1 month",
    "start_date": "2017-10-15T00:00:00+00:00",
    "type": "recurring",
    "purchase_completed_at": "2017-10-10T14:14:41+00:00",
    "purchase_state": "completed",
    "payment_state": "awaiting_payment",
    "token_value": "GpEwIpL474",
    "method": {
        "code": "directdebit",
        "position":1,
        "supports_recurring":true,
        "translations": {
            "en": {
                "locale": "en",
                "translatable": null,
                "id": 3,
                "name": "SEPA Direct Debit",
                "description": "My method description",
                "instructions": "My method instructions"
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
amount <br>(`required`)| int | The amount of the subscription. It needs to be integer value, e.g. if `5 USD` will be given, it needs to be increased by a factor of `100` which will result in `500`. The value can't be lower than `500`.
currency_code <br>(`required`)| string | The valid currency code, e.g. USD, EUR, PLN.
interval <br>(`optional`)| string | One of `3 months`, `1 month` or `1 year`. The frequency with which a subscription should be billed. `1 month` by default.
type <br>(`required`)| string | Subscription type (either `recurring` or `non-recurring`).
start_date | string | Subscription start date applies only to recurring subscriptions. Possible values are the 1st day of the current month and year, the 15th day of the current month and year, the 1st day of the next month and current year, the 15th day of the next month and current year. If the current date is lower than the one picked from the dates mentioned above, the API will return 400 status code.
method <br>(`required`)| string | Subscription's payment method. A value of payment method's code must be used here, e.g. `directdebit` (see [Payment Methods API](#payment-methods)).
metadata <br>(`optional`)| object | Set of key/value pairs that you can attach to an object. It can be useful for storing additional information about the object in a structured format.


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
  http://localhost/public-api/v1/subscriptions/lKD1QhGtjW/pay/?redirect=http://example.com/sub \
  -H 'content-type: application/json' \
```

> Response (302)

### Arguments

Name | Type | Description
--------- | ------- | -----------
tokenValue \(`required`)| string | The token value of the subscription to be paid (can be retrieved from Subscriptions API). It is generated once the subscription is created.
redirect \(`required`)| string | The URL you provide to redirect the customer to a url after payment is completed, failed or cancelled. Providing this parameter will override the default redirect urls.

### Returns

Returns an empty response with status code 302 if payment capture succeeded. Returns an error otherwise.
