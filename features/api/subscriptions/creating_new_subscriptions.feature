@subscriptions
Feature: Creating new subscriptions by admin
  In order to buy a subscription
  As a HTTP Client
  I want to make a request against subscription create endpoint

  Scenario: Create a new recurring subscription when no payment methods are defined
    Given I am authenticated as "admin"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": {
          "month": "10",
          "day": "10",
          "year": "2017"
       }
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | errors.children.method.errors[0] | This value should not be blank. |

  Scenario: Create a new recurring subscription when at least one payment method which supports recurring payments
    Given I am authenticated as "admin"
    And the system has a payment method "SEPA Direct Debit" with a code "directdebit" and a "directdebit" method using Mollie gateway which supports recurring
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": {
          "month": "10",
          "day": "10",
          "year": "2017"
       },
      "method": "directdebit"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | id                                    | 1                           |
      | currency_code                         | USD                         |
      | amount                                | 500                         |
      | interval                              | month                       |
      | start_date                            | 2017-10-10T00:00:00+00:00   |
      | type                                  | recurring                   |
      | purchase_state                        | completed                   |
      | payment_state                         | awaiting_payment            |
      | items_total                           | 500                         |
      | total                                 | 500                         |
      | state                                 | new                         |
      | items[0].quantity                     | 1                           |
      | items[0].unit_price                   | 500                         |
      | items[0].total                        | 500                         |
      | method.code                           | directdebit                 |
    And the JSON node "purchase_completed_at" should not be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "payments" should have 1 element
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "_links" should not be null

  Scenario: Create a new non-recurring subscription when at least one payment method supports non-recurring payments
    Given I am authenticated as "admin"
    And the system has a payment method "Lastschrift" with a code "lastschrift" and a "directdebit_oneoff" method using Mollie gateway which does not support recurring
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "type":"non-recurring",
      "method": "lastschrift"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | id                                    | 1                           |
      | currency_code                         | USD                         |
      | amount                                | 500                         |
      | type                                  | non-recurring               |
      | purchase_state                        | completed                   |
      | payment_state                         | awaiting_payment            |
      | items_total                           | 500                         |
      | total                                 | 500                         |
      | state                                 | new                         |
      | items[0].quantity                     | 1                           |
      | items[0].unit_price                   | 500                         |
      | items[0].total                        | 500                         |
      | method.code                           | lastschrift                 |
    And the JSON node "purchase_completed_at" should not be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "payments" should have 1 element
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "_links" should not be null

  Scenario: Create a new non-recurring subscription
    Given I am authenticated as "admin"
    And the system has a payment method "Offline" with a code "cash_on_delivery"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "type":"non-recurring",
      "method": "cash_on_delivery"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | id                                    | 1                           |
      | currency_code                         | USD                         |
      | amount                                | 500                         |
      | type                                  | non-recurring               |
      | items_total                           | 500                         |
      | total                                 | 500                         |
      | state                                 | new                         |
      | items[0].quantity                     | 1                           |
      | items[0].unit_price                   | 500                         |
      | items[0].total                        | 500                         |
      | purchase_state                        | completed                   |
      | payment_state                         | awaiting_payment            |
      | method.code                           | cash_on_delivery            |
    And the JSON node "start_date" should be null
    And the JSON node "interval" should be null
    And the JSON node "purchase_completed_at" should not be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "payments" should have 1 element
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "_links" should not be null

  Scenario: Create a new subscription when not authenticated
    Given I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "type":"non-recurring"
    }
    """
    Then the response status code should be 401
    And the response should be in JSON
