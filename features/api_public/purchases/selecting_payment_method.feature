@public_purchase
Feature: Selecting subscription payment method
  In order to pay for my subscription in a suitable way
  As a HTTP Client
  I want to be able to choose a payment method

  Scenario: Selecting PayPal payment method
    Given the system has a payment method "PayPal" with a code "paypal" and Paypal Express Checkout gateway
    And the system has also a new subscription priced at "$50"
    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "PUT" request to "/public-api/v1/purchase/payment/12345abcde" with body:
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

  Scenario: Selecting an offline method
    Given the system has a payment method "Offline" with a code "off"
    And the system has also a new subscription priced at "$50"
    Then I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "PUT" request to "/public-api/v1/purchase/payment/12345abcde" with body:
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
