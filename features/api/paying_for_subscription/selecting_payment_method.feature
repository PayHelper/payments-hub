@checkout
Feature: Selecting an order payment method
  In order to pay for my order in a suitable way
  As a HTTP Client
  I want to be able to choose a payment method

  @createSchema
  Scenario: Selecting PayPal payment method
    Given the system has a payment method "PayPal" with a code "paypal" and Paypal Express Checkout gateway
    And the system has also a new order with a code "my_sub" and name "My subscription" priced at "$50"
    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "PATCH" request to "/checkouts/payment/1" with body:
    """
        {
            "payments": [
                {
                    "method": "paypal"
                }
            ]
        }
    """
    Then the response status code should be 204

  @dropSchema
  Scenario: Selecting an offline method
    Given the system has a payment method "Offline" with a code "off"
    And the system has also a new order with a code "my_sub2" and name "My subscription2" priced at "$50"
    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "PATCH" request to "/checkouts/payment/2" with body:
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
