@payment_methods
Feature: Adding a new payment method
  In order to pay for subscriptions in different ways
  As a HTTP Client
  I want to make a request against payment method endpoint

  Scenario: Add a new offline payment method
    Given I am authenticated as "admin"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/payment-methods/new/offline" with body:
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

  Scenario: Adding a new paypal payment method
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
      | id                              | 1                           |
      | position                        | 2                           |
      | code                            | paypal                      |
      | enabled                         | 1                           |
      | translations.en.locale          | en                          |
      | translations.en.id              | 1                           |
      | gateway_config.id               | 1                           |
      | gateway_config.factory_name     | paypal_express_checkout     |
      | gateway_config.gateway_name     | testpay                     |
      | gateway_config.config.username  | test@example.com            |
      | gateway_config.config.password  | pass                        |
      | gateway_config.config.signature | signature12334              |
      | gateway_config.config.sandbox   | 1                           |


  Scenario: Adding a new Mollie credit card payment method
    Given I am authenticated as "admin"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/payment-methods/new/mollie" with body:
    """
    {
      "code":"credit_card",
      "position":"2",
      "enabled":"1",
      "gateway_config":{
        "config":{
          "apiKey":"apikey123456",
          "method":"creditcard"
        }
      },
      "translations":{
        "en":{
          "name":"Mollie Credit Card",
          "description":"desc",
          "instructions":"instructions"
        }
      }
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the JSON nodes should contain:
      | id                              | 1                           |
      | position                        | 2                           |
      | code                            | credit_card                 |
      | enabled                         | 1                           |
      | translations.en.locale          | en                          |
      | translations.en.id              | 1                           |
      | gateway_config.id               | 1                           |
      | gateway_config.factory_name     | mollie                      |
      | gateway_config.gateway_name     | mollie_credit_card          |
      | gateway_config.config.apiKey    | apikey123456                |
      | gateway_config.config.method    | creditcard                  |

  Scenario: Adding a new Mollie SEPA direct debit payment method
    Given I am authenticated as "admin"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/payment-methods/new/mollie" with body:
    """
    {
      "code":"sepa",
      "position":"2",
      "enabled":"1",
      "supportsRecurring":"1",
      "gateway_config":{
        "config":{
          "apiKey":"apikey123456",
          "method":"directdebit"
        }
      },
      "translations":{
        "en":{
          "name":"Mollie SEPA",
          "description":"desc",
          "instructions":"instructions"
        }
      }
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the JSON nodes should contain:
      | id                              | 1                           |
      | position                        | 2                           |
      | supports_recurring              | 1                           |
      | code                            | sepa                        |
      | enabled                         | 1                           |
      | translations.en.locale          | en                          |
      | translations.en.id              | 1                           |
      | gateway_config.id               | 1                           |
      | gateway_config.factory_name     | mollie                      |
      | gateway_config.gateway_name     | mollie_sepa                 |
      | gateway_config.config.apiKey    | apikey123456                |
      | gateway_config.config.method    | directdebit                 |

  Scenario: Adding a new Mollie fake payment method
    Given I am authenticated as "admin"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/payment-methods/new/mollie" with body:
    """
    {
      "code":"fake_code",
      "position":"2",
      "enabled":"1",
      "gateway_config":{
        "config":{
          "apiKey":"apikey123456",
          "method":"fake_method"
        }
      },
      "translations":{
        "en":{
          "name":"Mollie Fake",
          "description":"desc",
          "instructions":"instructions"
        }
      }
    }
    """
    Then the response status code should be 400
    And the response should be in JSON

  Scenario: Adding a new mbe4 payment method
    Given I am authenticated as "admin"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/payment-methods/new/mbe4" with body:
    """
    {
      "code":"mbe4",
      "position":"2",
      "enabled":"1",
      "gateway_config":{
        "config":{
          "username":"user",
          "password":"pass",
          "serviceId": "4321",
          "clientId": "1234",
          "contentclass": 1
        }
      },
      "translations":{
        "en":{
          "name":"Mbe4",
          "description":"desc",
          "instructions":"instructions"
        }
      }
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the JSON nodes should contain:
      | id                                  | 1                           |
      | position                            | 2                           |
      | code                                | mbe4                        |
      | enabled                             | 1                           |
      | translations.en.locale              | en                          |
      | translations.en.id                  | 1                           |
      | gateway_config.id                   | 1                           |
      | gateway_config.factory_name         | mbe4                        |
      | gateway_config.gateway_name         | mbe4                        |
      | gateway_config.config.username      | user                        |
      | gateway_config.config.password      | pass                        |
      | gateway_config.config.clientId      | 1234                        |
      | gateway_config.config.serviceId     | 4321                        |
      | gateway_config.config.contentclass  | 1                           |