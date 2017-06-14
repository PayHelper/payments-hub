@payment_methods
Feature: Listing payment methods
  In order to see all payment methods available in the system
  As a HTTP Client
  I want to be able to list all payment methods

  @createSchema
  @dropSchema
  Scenario: Retrieve the payment methods list
    Given the system has a payment method "Offline" with a code "off"
    And the system has a payment method "PayPal Express Checkout" with a code "paypal" and Paypal Express Checkout gateway
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/payment-methods/"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 2 elements
