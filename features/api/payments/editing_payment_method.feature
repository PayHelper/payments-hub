@payment_methods
Feature: Editing existing payment methods
  In order to change payment methods that are available in the system
  As a HTTP Client
  I want to be able to edit payment method

  Scenario: Renaming the payment method
    Given I am authenticated as "admin"
    And the system has a payment method "Offline" with a code "off"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "PATCH" request to "/api/v1/payment-methods/off" with body:
    """
    {
      "translations":{
        "en":{
          "name":"Cash on delivery"
        }
      }
    }
    """
    Then the response status code should be 204
    And the response should be empty
    Given I am authenticated as "admin"
    Given I am want to get JSON
    Then I send a "GET" request to "/api/v1/payment-methods/off"
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | translations.en.name  | Cash on delivery |
