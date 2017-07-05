@orders
Feature: Listing available orders
  In order to see available orders in the system
  As a HTTP Client
  I want to make a request against orders list endpoint

  @createSchema
  @dropSchema
  Scenario: List orders
    Given the system has a new order priced at "$50"
    Given the system has also a new order priced at "$300"
    When I send a "GET" request to "/orders/"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 2 elements
