@orders
Feature: Deleting existing order
  In order to delete order available in the system
  As a HTTP Client
  I want to be able to delete existing order

  Background:
    Given the system has a payment method "Offline" with a code "cash_on_delivery"
    And I am authenticated as "admin"
    And the system has also a new order with a code "my_sub" and name "My subscription" priced at "$50"

  Scenario: Delete a single order by id
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "DELETE" request to "/api/v1/orders/1"
    Then the response status code should be 204
    And the response should be empty
