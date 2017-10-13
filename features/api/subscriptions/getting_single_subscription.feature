@subscriptions
Feature: Getting a single subscription
  In order to show single subscription available in the system
  As a HTTP Client
  I want to make a request against subscription show endpoint

  Background:
    Given I am authenticated as "admin"

  Scenario: Get a single order
    And the system has a payment method "Offline" with a code "cash_on_delivery"
    And the system has also a new subscription priced at "$50"
    And I add "Accept" header equal to "application/json"
    When I am on "/api/v1/subscriptions/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | id                                    | 1                           |
      | currency_code                         | USD                         |
      | amount                                | 5000                        |
      | type                                  | non-recurring               |
      | items_total                           | 5000                        |
      | total                                 | 5000                        |
      | state                                 | new                         |
      | purchase_state                        | new                         |
      | payment_state                         | new                         |
      | token_value                           | 12345abcde                  |
    And the JSON node "purchase_completed_at" should be null
    And the JSON node "interval" should be null
    And the JSON node "start_date" should be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "items[0].quantity" should be equal to "1"
    And the JSON node "items[0].unit_price" should be equal to "5000"
    And the JSON node "items[0].total" should be equal to "5000"
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "payments" should have 1 element
    And the JSON node "_links" should not be null

  Scenario: Get not existing subscription
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And the header "Authorization" should not exist
    And I send a "GET" request to "/api/v1/subscriptions/999"
    Then the response status code should be 404
    And the response should be in JSON
