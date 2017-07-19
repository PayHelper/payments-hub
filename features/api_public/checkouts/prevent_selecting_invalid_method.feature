@public_checkout
Feature: Prevent completing checkout process when payment method not selected
  In order to be able to complete checkout process
  As a HTTP Client
  I want to be prevented from finishing the payment step with no method selected

    Background:
      Given the system has a payment method "Offline" with a code "off"
      And the system has also a new order with a code "my_sub" and name "My subscription" priced at "$50"

  Scenario: Prevent completing checkout process when payment method not selected
    Given I add "Accept" header equal to "application/json"
    And I send a "PATCH" request to "/public-api/v1/checkouts/complete/12345abcde"
    Then the response status code should be 500
    And the header "Content-Type" should be equal to "application/json"
