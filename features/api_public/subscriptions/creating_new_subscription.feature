@public_subscriptions
Feature: Creating a new subscription
  In order to pay for the service
  As a HTTP Client
  I want to make a request against subscription create endpoint

  Scenario: Create a new recurring subscription when no payment methods are defined
    When I add "Authorization" header equal to null
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
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
      | purchase_state                        | new                         |
      | payment_state                         | new                         |
      | items_total                           | 500                         |
      | total                                 | 500                         |
      | state                                 | new                         |
      | items[0].quantity                     | 1                           |
      | items[0].unit_price                   | 500                         |
      | items[0].total                        | 500                         |
    And the JSON node "purchase_completed_at" should be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "payments" should have 0 elements
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "_links" should not be null

  Scenario: Creating new subscription is not possible because the day of start date is wrong
    When I add "Authorization" header equal to null
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
	{
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": {
          "month": "22",
          "day": "10",
          "year": "2017"
       }
    }
    """
    Then the response status code should be 400
    And the response should be in JSON

  Scenario: Creating new subscription is not possible because the month of start date is wrong
    When I add "Authorization" header equal to null
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
	{
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": {
          "month": "10",
          "day": "9",
          "year": "2017"
       }
    }
    """
    Then the response status code should be 400
    And the response should be in JSON

  Scenario: Creating new subscription is not possible because the year of start date is wrong
    When I add "Authorization" header equal to null
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
	{
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": {
          "month": "10",
          "day": "10",
          "year": "2018"
       }
    }
    """
    Then the response status code should be 400
    And the response should be in JSON

  Scenario: Creating new subscription with the 15th day of start date
    When I add "Authorization" header equal to null
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
	{
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": {
          "month": "10",
          "day": "15",
          "year": "2017"
       }
    }
    """
    Then the response status code should be 201
    And the response should be in JSON

  Scenario: Creating new subscription with the 1st day of start date
    When I add "Authorization" header equal to null
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
	{
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": {
          "month": "10",
          "day": "1",
          "year": "2017"
       }
    }
    """
    Then the response status code should be 201
    And the response should be in JSON

  Scenario: Creating new subscription with the upcoming month of the given one in start date
    When I add "Authorization" header equal to null
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
	{
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": {
          "month": "11",
          "day": "1",
          "year": "2017"
       }
    }
    """
    Then the response status code should be 201
    And the response should be in JSON

  Scenario: Creating new subscription with the next month of the upcoming month in start date
    When I add "Authorization" header equal to null
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
	{
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": {
          "month": "12",
          "day": "1",
          "year": "2017"
       }
    }
    """
    Then the response status code should be 201
    And the response should be in JSON

  Scenario: Create a new subscription when at least one payment method is defined
    Given the system has a payment method "Offline" with a code "cash_on_delivery"
    When I add "Authorization" header equal to null
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
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
      | items_total                           | 500                         |
      | total                                 | 500                         |
      | state                                 | new                         |
      | items[0].quantity                     | 1                           |
      | items[0].unit_price                   | 500                         |
      | items[0].total                        | 500                         |
      | purchase_state                        | new                         |
      | payment_state                         | new                         |
    And the JSON node "purchase_completed_at" should be null
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
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "type":"non-recurring"
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
      | purchase_state                        | new                         |
      | payment_state                         | new                         |
    And the JSON node "start_date" should be null
    And the JSON node "token_value" should not be null
    And the JSON node "interval" should be null
    And the JSON node "purchase_completed_at" should be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "payments" should have 1 element
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "_links" should not be null
