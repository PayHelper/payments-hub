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
    And the JSON node "subscription.currency_code" should be equal to "USD"
    And the JSON node "subscription.amount" should be equal to "500"
    And the JSON node "subscription.interval" should be equal to "month"
    And the JSON node "items_total" should be equal to "500"
    And the JSON node "total" should be equal to "500"
    And the JSON node "checkout_completed_at" should be null
    And the JSON node "checkout_state" should be equal to "cart"
    And the JSON node "payment_state" should be equal to "cart"
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "_links" should not be null
