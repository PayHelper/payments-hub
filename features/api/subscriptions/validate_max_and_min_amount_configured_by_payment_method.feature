@subscriptions
Feature: Prevent creating a new subscription if the gateway's config of a payment method limits the value of subscription's amount
  In order to be able to create a subscription with an amount which is defined by the payment method
  As a HTTP Client
  I want to make a request against subscription create endpoint

  Scenario: Validate the subscription's amount field based on the payment method's gateway configuration
    Given I am authenticated as "admin"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/payment-methods/new/paypal_express_checkout" with body:
    """
    {
      "code":"paypal",
      "position":"2",
      "enabled":"1",
      "gateway_config":{
        "config":{
          "username":"test@example.com",
          "password":"pass",
          "signature":"signature12334",
          "sandbox":"1",
          "minAmount":100,
          "maxAmount":500
        }
      },
      "translations":{
        "en":{
          "name":"testpay",
          "description":"desc",
          "instructions":"instructions"
        }
      }
    }
    """
    Then the response status code should be 201
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/subscriptions/" with body:
    """
    {
      "amount":50,
      "currency_code":"USD",
      "type":"non-recurring",
       "method": "paypal"
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | errors.children.amount.errors[0] | This value should be 1 or more. |
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/subscriptions/" with body:
    """
    {
      "amount":600,
      "currency_code":"USD",
      "type":"non-recurring",
       "method": "paypal"
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | errors.children.amount.errors[0] | This value should be 5 or less. |
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/subscriptions/" with body:
    """
    {
      "amount":100,
      "currency_code":"USD",
      "type":"non-recurring",
       "method": "paypal"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | amount | 100 |
