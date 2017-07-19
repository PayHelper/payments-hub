@payment_methods
Feature: Deleting existing payment method
  In order to delete a payment method available in the system
  As a HTTP Client
  I want to be able to delete existing payment method

  Scenario: Delete a single payment by code
    Given I am authenticated as "admin"
    And the system has a payment method "Offline" with a code "cash_on_delivery"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "DELETE" request to "/api/v1/payment-methods/cash_on_delivery"
    Then the response status code should be 204
    And the response should be empty
