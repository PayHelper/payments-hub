@public_purchase
Feature: Paying offline for a subscription
  In order to pay with cash or by external means
  As a HTTP Client
  I want to be able to complete purchase by paying offline

  Scenario: Paying for a non-recurring subscription
    Given the system has a payment method "Offline" with a code "off"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
    {
      "amount":5000,
      "currency_code":"USD",
      "type":"non-recurring",
      "method": "off"
    }
    """
    Then the response status code should be 201
    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde"
    Then the response status code should be 200
    And the JSON node "purchase_state" should be equal to "completed"
    And the JSON node "payment_state" should be equal to "awaiting_payment"
    And the JSON node "amount" should be equal to "5000"
    And the JSON node "token_value" should be equal to "12345abcde"
    And the JSON node "method.code" should be equal to "off"
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde/pay/"
    Then the response status code should be 302
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde"
    Then the response status code should be 200
    And the JSON node "purchase_state" should be equal to "completed"
    And the JSON node "payment_state" should be equal to "awaiting_payment"
    And the JSON node "amount" should be equal to "5000"
    And the JSON node "token_value" should be equal to "12345abcde"
    And the JSON node "state" should be equal to "new"
    And the JSON node "token_value" should be equal to "12345abcde"
    And the JSON node "method.code" should be equal to "off"

  Scenario: Paying for a recurring subscription
    Given the system has a payment method "Offline" with a code "off"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": "2017-10-10",
      "method": "off"
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | errors.children.method.errors[0] | This value is not valid. |

  Scenario: Completing successfully bought non-recurring subscription
    Given the system has a payment method "Offline" with a code "off"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
    {
      "amount":5000,
      "currency_code":"USD",
      "type":"non-recurring",
      "method": "off"
    }
    """
    Then the response status code should be 201

    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde"
    Then the response status code should be 200

    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde/pay/"
    Then the response status code should be 302

    Given I am authenticated as "admin"
    Given I am want to get JSON
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "PUT" request to "/api/v1/subscriptions/1/payments/1/complete"
    Then the response status code should be 204

    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/public-api/v1/subscriptions/12345abcde"
    Then the response status code should be 200
    And the JSON node "purchase_state" should be equal to "completed"
    And the JSON node "state" should be equal to "fulfilled"
    And the JSON node "payment_state" should be equal to "paid"
