@orders
Feature: Placing a new order
  In order to buy a subscription/place an order
  As a HTTP Client
  I want to make a request against order create endpoint

  @createSchema
  @dropSchema
  Scenario: Place a new order
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/orders/create/" with body:
    """
    {
      "amount":500,
      "currencyCode":"USD",
      "interval":"month"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | id                           | 1                                        |
      | subscription.id              | 1                                        |
      | subscription.currency_code   | USD                                      |
      | subscription.amount          | 500                                      |
      | subscription.interval        | month                                    |
      | items_total                  | 500                                      |
      | total                        | 500                                      |
      | state                        | cart                                     |
    And the JSON node "checkout_completed_at" should be null
    And the JSON node "number" should be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "items[0].quantity" should be equal to "1"
    And the JSON node "items[0].unit_price" should be equal to "500"
    And the JSON node "items[0].total" should be equal to "500"
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "_links" should not be null
