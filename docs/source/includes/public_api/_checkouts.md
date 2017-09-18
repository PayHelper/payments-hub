# Checkouts

These endpoints will allow you to easily go through the order checkout process resulting in paying for order and finalizing the checkout.

The checkout can be performed only when there is an order created.

Checkouts API consists of two steps which must be executed in the exact order, unless you customize it:

1. Select a payment method
2. Pay for an order

## Select a payment method

> Definition

```shell
PATCH https://localhost/public-api/v1/checkouts/payment/{tokenValue}
```

This endpoint allows to select one of the payment methods which exists in the system and assign it to the order.

For example, if you have placed a new order and you want to pay for it, you can choose whether you want to pay using PayPal or offline etc.

Once the payment method is selected, the state of an order will change from `cart` to `new`, the checkout state of an order will change from `cart` to `payment_selected` and the order payment state will change from state `cart` to `awaiting_payment`.

After this endpoint is successfully called, there will be a possibility to complete the checkout.

<aside class="notice">You can check the <a href='https://github.com/sourcefabric/payments-hub/blob/master/src/PH/Bundle/CoreBundle/Resources/config/app/state_machine/ph_order_checkout.yml'>configuration</a> of the state machine to see the configured states and transitions.</aside>

> Example Request

```shell
curl -X PATCH \
  http://localhost/public-api/v1/checkouts/payment/lKD1QhGtjW \
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
tokenValue \(`required`)| string | The token value of the order to be paid (can be retrieved from Orders API). It is generated once the order is created.
payments (`required`)| array | An array of selected payment methods.

### Returns 

Returns an empty response if selecting payment method succeeded. Returns an error if selecting payment method can not be done (e.g. when the selected payment method does not exist or an order does not exist).

## Pay for an order

> Definition

```shell
GET http://localhost/public-api/v1/checkouts/pay/{tokenValue}
```

Calling this endpoint will automatically prepare capture and redirect to a proper payment gateway that was selected during the checkout in order to pay for an order (e.g. when a PayPal payment method is selected for order payments and this endpoint will be called, it will perform a redirect to a PayPal page to pay for the goods and if the payment succeeded or failed it will redirect to `thank you` endpoint which will return no content but a proper status code.)

Once the payment transaction is finalized successfully the order state is changed from `new` to `fullfiled` and the order payment state is changed from `awaiting_payment` to `paid`.

> Example Request

```shell
curl -X GET \
  http://localhost/public-api/v1/checkouts/pay/lKD1QhGtjW \
  -H 'content-type: application/json' \
```

> Response (302)

### Arguments

Name | Type | Description
--------- | ------- | -----------
tokenValue \(`required`)| string | The token value of the order to be paid (can be retrieved from Orders API). It is generated once the order is created.

### Returns

Returns an empty response with status code 302 if checkout payment capture succeeded. Returns an error if complete can not be done.
