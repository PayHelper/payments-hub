@payment_gateways
Feature: Listing available payment gateways
  In order to see all payment gateways available in the system
  As a HTTP Client
  I want to be able to list all of them

  Scenario: Retrieve the list of payment gateways
    Given I am authenticated as "admin"
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/api/v1/payment-gateways/"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "mollie" should exist
    And the JSON node "mbe4" should exist
    And the JSON node "paypal_express_checkout" should exist
    And the JSON node "stripe_checkout" should exist
    And the JSON node "offline" should exist
