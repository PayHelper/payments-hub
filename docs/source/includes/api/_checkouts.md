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

After this endpoint is successfully called, there will be a possibility to complete the checkout.

<aside class="notice">You can check the <a href='https://github.com/sourcefabric/payments-hub/blob/master/src/PH/Bundle/CoreBundle/Resources/config/app/state_machine/ph_order_checkout.yml'>configuration</a> of the state machine to see the configured states and transitions.</aside>

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

<aside class="success">
The <b>PUT</b> method is also supported by this endpoint.
</aside>

> Response (204 No Content)

### Arguments

Name | Type | Description
--------- | ------- | -----------
orderId (`required`)| integer | The identifier of the order for which the payment method is selected.
payments (`required`)| array | An array of selected payment methods.

### Returns 

Returns an empty response if selecting payment method succeeded. Returns an error if selecting payment method can not be done (e.g. when the selected payment method does not exist or an order does not exist).

## Complete the checkout

> Definition

```shell
PATCH https://localhost/api/v1/checkouts/complete/{orderId}
```

Here, after the payment method is selected, you can complete the order checkout to be able to pay for an order using the previously selected payment method.

Once this endpoint is called, the order checkout state will change from `payment_selected` to `completed` and order payment state will change from `cart` to `awaiting_payment`.

<aside class="notice">You can check the <a href='https://github.com/sourcefabric/payments-hub/blob/master/src/PH/Bundle/CoreBundle/Resources/config/app/state_machine/ph_order_checkout.yml'>configuration</a> of the state machine to see the configured states and transitions.</aside>

> Example Request

```shell
curl -X PATCH \
  http://localhost/api/v1/checkouts/complete/1 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
  -d '{
  "notes": "Thanks for your great content!"
}'
```

> Response (200)

```json
{
    "id": 1,
    "checkout_completed_at": "2017-07-10T14:27:47+0200",
    "number": "000000001",
    "notes": "Thanks for your great content!",
    "items": [
        {
            "id": 1,
            "quantity": 1,
            "unit_price": 5000,
            "total": 5000,
            "subscription": {
                "id": 1,
                "amount": "5000",
                "currency_code": "PLN",
                "interval": "month",
                "name": "Monthly subscription",
                "code": "monthly_subscription",
                "created_at": "2017-07-10T14:27:19+0200",
                "updated_at": "2017-07-10T14:27:19+0200"
            },
            "_links": {
                "order": {
                    "href": "/app_dev.php/api/v1/orders/36"
                }
            }
        }
    ],
    "items_total": 5000,
    "total": 5000,
    "state": "new",
    "created_at": "2017-07-10T14:27:19+0200",
    "updated_at": "2017-07-10T14:27:47+0200",
    "payments": [
        {
            "id": 1,
            "method": {
                "id": 2,
                "code": "paypal",
                "position": 1,
                "created_at": "2017-07-06T16:32:48+0200",
                "updated_at": "2017-07-06T16:32:50+0200",
                "enabled": true,
                "translations": {
                    "en": {
                        "locale": "en",
                        "translatable": null,
                        "id": 2,
                        "name": "testpay",
                        "description": "desc",
                        "instructions": "instructions"
                    }
                },
                "_links": {
                    "self": {
                        "href": "/api/v1/payment-methods/paypal"
                    }
                }
            },
            "currency_code": "PLN",
            "amount": 5000,
            "state": "new",
            "created_at": "2017-07-10T14:27:19+0200",
            "updated_at": "2017-07-10T14:27:47+0200"
        }
    ],
    "checkout_state": "completed",
    "payment_state": "awaiting_payment",
    "token_value": "lKD1QhGtjW",
    "_links": {
        "self": {
            "href": "/api/v1/orders/36"
        }
    }
}
```

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

Calling this endpoint will automatically prepare capture and redirect to a proper payment gateway that was selected during the checkout in order to pay for an order (e.g. when a PayPal payment method is selected for order payments and this endpoint will be called, it will perform a redirect to a PayPal page to pay for the goods and if the payment succeeded or failed it will redirect to `thank you` endpoint which will return no content but a proper status code.)

Once the payment transaction is finalized successfully the order state is changed from `new` to `fullfiled` and the order payment state is changed from `awaiting_payment` to `paid`.

> Example Request

```shell
curl -X GET \
  http://localhost/api/v1/checkouts/pay/z~ADQ18G~3 \
  -H 'authorization: Bearer key' \
  -H 'content-type: application/json' \
```

> Response (302)

### Arguments

Name | Type | Description
--------- | ------- | -----------
tokenValue \(`required`)| string | The token value of the order to be paid (can be retrieved from Orders API). It is generated once the checkout is completed.

### Returns

Returns an empty response with status code 302 if checkout payment capture succeeded. Returns an error if complete can not be done.
