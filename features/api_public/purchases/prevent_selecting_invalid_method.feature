@public_purchase
Feature: Prevent paying for subscripton when payment method not defined
  In order to be able to complete purchase
  As a HTTP Client
  I want to be prevented from paying for subscription when no payment method is defined

  Scenario: Prevent completing purchase when payment method not selected
    Given the system has also a new subscription priced at "$50"
    Then I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/public-api/v1/purchase/pay/12345abcde"
    Then the response status code should be 404
    And the header "Content-Type" should be equal to "application/json"
