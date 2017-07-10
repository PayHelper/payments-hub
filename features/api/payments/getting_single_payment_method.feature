@payment_methods
Feature: Getting a single payment method
  In order list a single payment method available in the system
  As a HTTP Client
  I want to be able to get info about single payment method

  @createSchema
  Scenario: Get payment method by code
    Given the system has a payment method "Offline" with a code "off"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/payment-methods/off"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "translations" should have 1 element
    And the JSON node "translations.en.translatable" should be null
    And the JSON node "created_at" should not be null
    And the JSON nodes should contain:
    | id                           | 1                                        |
    | position                     | 0                                        |
    | code                         | off                                      |
    | translations.en.locale       | en                                       |
    | translations.en.locale       | en                                       |
    | translations.en.id           | 1                                        |
    | translations.en.name         | Offline                                  |
    | gateway_config.id            | 1                                        |
    | gateway_config.factory_name  | offline                                  |
    | gateway_config.gateway_name  | offline                                  |

  @dropSchema
  Scenario: Get not existing payment method by code
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/payment-methods/cash_on_delivery"
    Then the response status code should be 404
    And the response should be in JSON
