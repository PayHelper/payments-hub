@payment_methods
Feature: Listing payment methods
  In order to see all payment methods available in the system
  As a HTTP Client
  I want to be able to list all payment methods

  Scenario: Retrieve the payment methods list
    Given the system has a payment method "Offline" with a code "off"
    And the system has a payment method "PayPal Express Checkout" with a code "paypal" and Paypal Express Checkout gateway
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/public-api/v1/payment-methods/"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 2 elements
    And the JSON node "_embedded.items[0].enabled" should not exist
    And the JSON node "_embedded.items[0].created_at" should not exist
    And the JSON node "_embedded.items[0].updated_at" should not exist
    And the JSON node "_embedded.items[0].gateway_config" should not exist
    And the JSON node "_embedded.items[1].enabled" should not exist
    And the JSON node "_embedded.items[1].created_at" should not exist
    And the JSON node "_embedded.items[1].updated_at" should not exist
    And the JSON node "_embedded.items[1].gateway_config" should not exist

  Scenario: Retrieve the payment methods which support recurring payments only
    And the system has a payment method "Offline" with a code "off"
    And the system has a payment method "PayPal Express Checkout" with a code "paypal" and Paypal Express Checkout gateway
    And the system has a payment method "SEPA Direct Debit" with a code "sepa" and a "directdebit" method using Mollie gateway which supports recurring
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/public-api/v1/payment-methods/?supportsRecurring=1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 1 element

  Scenario: Retrieve the payment methods which do not support recurring payments
    And the system has a payment method "Offline" with a code "off"
    And the system has a payment method "PayPal Express Checkout" with a code "paypal" and Paypal Express Checkout gateway
    And the system has a payment method "SEPA Direct Debit" with a code "sepa" and a "directdebit" method using Mollie gateway which supports recurring
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/public-api/v1/payment-methods/?supportsRecurring=0"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 2 elements
