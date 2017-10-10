@subscriptions
Feature: Listing available subscriptions
  In order to see available subscriptions in the system
  As a HTTP Client
  I want to make a request against subscriptions list endpoint

  Scenario: List subscriptions
    Given I am authenticated as "admin"
    And the system has a payment method "Offline" with a code "cash_on_delivery"
    And the system has also a new subscription priced at "$50"
    And the system has also a new subscription priced at "$300"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/api/v1/subscriptions/"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 2 elements
