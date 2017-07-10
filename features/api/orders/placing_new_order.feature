@orders
Feature: Placing a new order
  In order to buy a subscription/place an order
  As a HTTP Client
  I want to make a request against order create endpoint

  @createSchema
  Scenario: Place a new order when no payment methods are defined
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/orders/create/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "interval":"month",
      "name": "My monthly subscription",
      "code": "monthly_subscription"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | id                                    | 1                           |
      | items[0].subscription.id              | 1                           |
      | items[0].subscription.currency_code   | USD                         |
      | items[0].subscription.amount          | 500                         |
      | items[0].subscription.interval        | month                       |
      | items[0].subscription.name            | My monthly subscription     |
      | items[0].subscription.code            | monthly_subscription        |
      | items_total                           | 500                         |
      | total                                 | 500                         |
      | state                                 | cart                        |
      | items[0].quantity                     | 1                           |
      | items[0].unit_price                   | 500                         |
      | items[0].total                        | 500                         |
    And the JSON node "checkout_completed_at" should be null
    And the JSON node "number" should be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "payments" should have 0 elements
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "_links" should not be null

  @dropSchema
  Scenario: Place a new order when at least one payment method is defined
    Given the system has a payment method "Offline" with a code "cash_on_delivery"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/orders/create/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "interval":"month",
      "name": "My monthly subscription",
      "code": "monthly_subscription"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | id                                    | 2                           |
      | items[0].subscription.id              | 2                           |
      | items[0].subscription.currency_code   | USD                         |
      | items[0].subscription.amount          | 500                         |
      | items[0].subscription.interval        | month                       |
      | items[0].subscription.name            | My monthly subscription     |
      | items[0].subscription.code            | monthly_subscription        |
      | items_total                           | 500                         |
      | total                                 | 500                         |
      | state                                 | cart                        |
      | items[0].quantity                     | 1                           |
      | items[0].unit_price                   | 500                         |
      | items[0].total                        | 500                         |
      | checkout_state                        | cart                        |
      | payment_state                         | cart                        |
    And the JSON node "checkout_completed_at" should be null
    And the JSON node "number" should be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "payments" should have 1 element
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "_links" should not be null
