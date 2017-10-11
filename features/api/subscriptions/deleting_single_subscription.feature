@subscriptions
Feature: Deleting existing subscription
  In order to delete existing subscription available in the system
  As a HTTP Client
  I want to be able to delete it

  Background:
    Given the system has a payment method "Offline" with a code "cash_on_delivery"
    And I am authenticated as "admin"
    And the system has also a new subscription priced at "$50"

  Scenario: Delete a single order by id
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "DELETE" request to "/api/v1/subscriptions/1"
    Then the response status code should be 204
    And the response should be empty
