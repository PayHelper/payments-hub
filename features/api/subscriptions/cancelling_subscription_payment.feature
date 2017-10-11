@subscriptions
Feature: Cancelling existing subscriptions's payment
  In order to cancel existing recurring subscription
  As a HTTP Client
  I want to be able to cancel it

  Background:
    Given the system has a payment method "Offline" with a code "cash_on_delivery"
    And I am authenticated as "admin"
    And the system has also a new subscription priced at "$50"

  Scenario: Cancel a single subscription's payments by id and subscription id
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "DELETE" request to "/api/v1/subscriptions/1/payments/1/cancel"
    Then the response status code should be 302
    And the response should be empty
    And the header "Location" should contain "http://example.com/payment/cancel/"
