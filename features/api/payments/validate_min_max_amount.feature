@payment_methods
Feature: Validating min and max amount supported by payment gateway
  In order to limit max and min amount that will be handled by payment gateway
  As a HTTP Client
  I want to make a request against payment method endpoint to set those limits

  Scenario: Adding a new PayPal payment method with invalid min amount
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
          "minAmount":"fake",
          "maxAmount":1000
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
    Then the response status code should be 400
    And the response should be in JSON

  Scenario: Adding a new PayPal payment method with invalid max amount
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
          "minAmount":50,
          "maxAmount":"fake"
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
    Then the response status code should be 400
    And the response should be in JSON

  Scenario: Adding a new PayPal payment method with invalid max and min amount values
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
          "minAmount":"fake",
          "maxAmount":"fake"
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
    Then the response status code should be 400
    And the response should be in JSON
