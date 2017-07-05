@orders
Feature: Getting a single order
  In order to show single order available in the system
  As a HTTP Client
  I want to make a request against order show endpoint

  @createSchema
  Scenario: Get a single order
    Given the system has a new order priced at "$50"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/orders/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | id                           | 1                  |
      | subscription.id              | 1                  |
      | subscription.currency_code   | USD                |
      | subscription.amount          | 5000               |
      | subscription.interval        | month              |
      | items_total                  | 5000               |
      | total                        | 5000               |
      | state                        | cart               |
    And the JSON node "checkout_completed_at" should be null
    And the JSON node "number" should be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "items[0].quantity" should be equal to "1"
    And the JSON node "items[0].unit_price" should be equal to "5000"
    And the JSON node "items[0].total" should be equal to "5000"
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "_links" should not be null

  @dropSchema
  Scenario: Get not existing order
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/orders/999"
    Then the response status code should be 404
    And the response should be in JSON
