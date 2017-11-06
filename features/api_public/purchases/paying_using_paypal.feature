@public_purchase
Feature: Paying for a subscription using PayPal
  In order to pay with PayPal Express Checkout
  As a HTTP Client
  I want to be able to finalize purchase by paying using PayPal Express Checkout

  Scenario: Paying for non-recurring subscription using PayPal Express Checkout
    Given the system has a payment method "PayPal" with a code "paypal" and Paypal Express Checkout gateway
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "type":"non-recurring",
      "method": "paypal"
    }
    """
    Then the response status code should be 201
    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde"
    Then the response status code should be 200
    And the JSON node "purchase_state" should be equal to "completed"
    And the JSON node "payment_state" should be equal to "awaiting_payment"
    And the JSON node "amount" should be equal to "500"
    And the JSON node "token_value" should be equal to "12345abcde"
    And the JSON node "method.code" should be equal to "paypal"
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde/pay/"
    Then the response status code should be 302
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde"
    Then the response status code should be 200
    And the JSON node "purchase_state" should be equal to "completed"
    And the JSON node "payment_state" should be equal to "awaiting_payment"
    And the JSON node "amount" should be equal to "500"
    And the JSON node "state" should be equal to "new"
    And the JSON node "token_value" should be equal to "12345abcde"
    And the JSON node "method.code" should be equal to "paypal"

  Scenario: Paying for a recurring subscription using PayPal
    Given the system has a payment method "Paypal" with a code "paypal" and Paypal Express Checkout gateway
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": {
          "month": "10",
          "day": "10",
          "year": "2017"
       },
      "method": "paypal"
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | errors.children.method.errors[0] | This value is not valid. |