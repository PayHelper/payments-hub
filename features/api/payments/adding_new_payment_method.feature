@payment_methods
Feature: Adding a new payment method
  In order to pay for subscriptions in different ways
  As a HTTP Client
  I want to make a request against payment method endpoint

  @createSchema
  Scenario: Add a new offline payment method
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/payment-methods/new/offline" with body:
    """
    {
      "code": "cash_on_delivery",
      "position": "1",
      "enabled": "1",
      "translations": {
        "en": {
          "name": "offline",
          "description": "desc",
          "instructions": "instructions"
        }
      }
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "translations" should have 1 element
    And the JSON node "translations.en.translatable" should be null
    And the JSON node "created_at" should not be null
    And the JSON nodes should contain:
      | id                           | 1                                        |
      | position                     | 1                                        |
      | code                         | cash_on_delivery                         |
      | translations.en.locale       | en                                       |
      | translations.en.locale       | en                                       |
      | translations.en.id           | 1                                        |
      | translations.en.name         | offline                                  |
      | translations.en.description  | desc                                     |
      | translations.en.instructions | instructions                             |
      | gateway_config.id            | 1                                        |
      | gateway_config.factory_name  | offline                                  |
      | gateway_config.gateway_name  | offline                                  |

  @dropSchema
  Scenario: Adding a new paypal payment method
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/payment-methods/new/paypal_express_checkout" with body:
    """
    {
      "code":"paypal",
      "position":"2",
      "enabled":"1",
      "gatewayConfig":{
        "config":{
          "username":"test@example.com",
          "password":"pass",
          "signature":"signature12334",
          "sandbox":"1"
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
    And the response should be in JSON
    And the JSON nodes should contain:
      | id                              | 2                           |
      | position                        | 2                           |
      | code                            | paypal                      |
      | enabled                         | 1                           |
      | translations.en.locale          | en                          |
      | translations.en.id              | 2                           |
      | gateway_config.id               | 2                           |
      | gateway_config.factory_name     | paypal_express_checkout     |
      | gateway_config.gateway_name     | testpay                     |
      | gateway_config.config.username  | test@example.com            |
      | gateway_config.config.password  | pass                        |
      | gateway_config.config.signature | signature12334              |
      | gateway_config.config.sandbox   | 1                           |
