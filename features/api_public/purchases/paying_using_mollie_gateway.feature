@public_purchase
Feature: Paying for a subscription using Mollie gateway
  In order to pay with PayPal Express Checkout
  As a HTTP Client
  I want to be able to finalize purchase by paying using PayPal Express Checkout

  Scenario: Paying for non-recurring subscription using Mollie
    Given the system has a payment method "Lastschrift" with a code "lastschrift" and a "directdebit_oneoff" method using Mollie gateway which does not support recurring
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "type":"non-recurring",
      "method": "lastschrift"
    }
    """
    Then the response status code should be 201
    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde"
    Then the response status code should be 200
    And the JSON node "purchase_state" should be equal to "completed"
    And the JSON node "payment_state" should be equal to "awaiting_payment"
    And the JSON node "total" should be equal to "500"
    And the JSON node "token_value" should be equal to "12345abcde"
    And the JSON node "method.code" should be equal to "lastschrift"
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde/pay/"
    Then the response status code should be 302
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde"
    Then the response status code should be 200
    And the JSON node "purchase_state" should be equal to "completed"
    And the JSON node "payment_state" should be equal to "awaiting_payment"
    And the JSON node "total" should be equal to "500"
    And the JSON node "token_value" should be equal to "12345abcde"
    And the JSON node "state" should be equal to "new"
    And the JSON node "method.code" should be equal to "lastschrift"

  Scenario: Paying for a recurring subscription using Mollie
    Given the system has a payment method "SEPA Direct Debit" with a code "sepa" and a "directdebit" method using Mollie gateway which supports recurring
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
      "method": "sepa"
    }
    """
    Then the response status code should be 201
    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde"
    Then the response status code should be 200
    And the JSON node "purchase_state" should be equal to "completed"
    And the JSON node "payment_state" should be equal to "awaiting_payment"
    And the JSON node "total" should be equal to "500"
    And the JSON node "token_value" should be equal to "12345abcde"
    And the JSON node "method.code" should be equal to "sepa"
    And the JSON node "type" should be equal to "recurring"
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde/pay/"
    Then the response status code should be 302
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde"
    Then the response status code should be 200
    And the JSON node "purchase_state" should be equal to "completed"
    And the JSON node "payment_state" should be equal to "awaiting_payment"
    And the JSON node "total" should be equal to "500"
    And the JSON node "token_value" should be equal to "12345abcde"
    And the JSON node "state" should be equal to "new"
    And the JSON node "method.code" should be equal to "sepa"
    And the JSON node "type" should be equal to "recurring"