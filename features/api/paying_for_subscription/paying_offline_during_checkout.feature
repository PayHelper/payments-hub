@paying_for_subscription
Feature: Paying offline during checkout
  In order to pay with cash or by external means
  As a HTTP Client
  I want to be able to complete checkout process without paying

  Scenario: Successfully placing an order
    Given I am authenticated as "admin"
    And the system has a payment method "Offline" with a code "off"
    And the system has also a new order with a code "my_sub" and name "My subscription" priced at "$50"
    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "PUT" request to "/api/v1/checkouts/payment/1" with body:
    """
        {
            "payments": [
                {
                    "method": "off"
                }
            ]
        }
    """
    Then the response status code should be 204
    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/api/v1/checkouts/1"
    Then the response status code should be 200
    And the JSON node "checkout_state" should be equal to "completed"
    And the JSON node "payment_state" should be equal to "awaiting_payment"
    And the JSON node "total" should be equal to "5000"
    And the JSON node "token_value" should not be null
    And the JSON node "number" should not be null
