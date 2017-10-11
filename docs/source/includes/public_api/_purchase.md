# Purchase

These endpoints will allow you to easily go through the subscription checkout process resulting in paying for subscription and finalizing the purchase.

The purchase can be performed only when there is a subscription created.

Purchase API consists of two steps which must be executed in the exact order:

1. Select a payment method
2. Pay for subscription

## Select a payment method

> Definition

```shell
PATCH https://localhost/public-api/v1/purchase/payment/{tokenValue}
```

This endpoint allows to select one of the payment methods which exists in the system and assign it to the subscription.

For example, if you have created a new subscription using [Subscriptions API](#subscriptions11), and you want to pay for it, you can choose whether you want to pay using PayPal or offline etc.

Once the payment method is selected, the state of the subscription will be `new`, the purchase state of subscription will change from `cart` to `payment_selected` and the subscription's payment state will change from state `cart` to `awaiting_payment`.

After this endpoint is successfully called, there will be a possibility to perform a payment.

<aside class="notice">You can check the <a href='https://github.com/sourcefabric/payments-hub/blob/master/src/PH/Bundle/CoreBundle/Resources/config/app/state_machine/ph_subscription_checkout.yml'>configuration</a> of the state machine to see the configured states and transitions.</aside>

> Example Request

```shell
curl -X PATCH \
  http://localhost/public-api/v1/purchase/payment/lKD1QhGtjW \
  -H 'accept: application/json' \
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
tokenValue \(`required`)| string | The token value of the subscription to be paid (can be retrieved from Subscriptions API). It is generated once the subscription is created.
payments (`required`)| array | An array of selected payment methods.

### Returns 

Returns an empty response if selecting payment method succeeded. Returns an error if selecting payment method can not be done (e.g. when the selected payment method does not exist or subscription does not exist).

## Pay for subscription

> Definition

```shell
GET http://localhost/public-api/v1/purchase/pay/{tokenValue}
```

Calling this endpoint will automatically prepare capture and redirect to a proper payment gateway that was selected during the purchase in order to pay for subscription (e.g. when a PayPal payment method is selected and the above endpoint will be called, the app will perform a redirect to a PayPal page to pay for the subscription and if the payment succeeded or failed it will redirect to `thank you` endpoint which will return no content but a proper status code.)

Once the payment transaction is finalized successfully the subscription state is changed from `new` to `fullfiled` and the subscription's payment state is changed from `awaiting_payment` to `paid`.

> Example Request

```shell
curl -X GET \
  http://localhost/public-api/v1/purchase/pay/lKD1QhGtjW \
  -H 'content-type: application/json' \
```

> Response (302)

### Arguments

Name | Type | Description
--------- | ------- | -----------
tokenValue \(`required`)| string | The token value of the subscription to be paid (can be retrieved from Subscriptions API). It is generated once the subscription is created.

### Returns

Returns an empty response with status code 302 if payment capture succeeded. Returns an error otherwise.
