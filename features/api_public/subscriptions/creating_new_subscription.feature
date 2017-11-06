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
       },
      "intention":"bottom_box",
      "source":"mobile_version"
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | errors.children.method.errors[0] | This value should not be blank. |


  Scenario: Create a new subscription when at least one payment method is defined
    Given the system has a payment method "SEPA Direct Debit" with a code "sepa" and a "directdebit" method using Mollie gateway which supports recurring
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
      },
      "method":"sepa",
      "metadata": {
          "intention":"bottom_box",
          "source":"web_version"
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
      | purchase_state                        | completed                   |
      | payment_state                         | awaiting_payment            |
      | method.code                           | sepa                        |
      | metadata.intention                    | bottom_box                  |
      | metadata.source                       | web_version                 |
    And the JSON node "metadata" should have 2 elements
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
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "type":"non-recurring",
      "method":"cash_on_delivery",
      "metadata": {
          "intention":"bottom_box",
          "source":"web_version",
          "custom":"custom value"
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
      | type                                  | non-recurring               |
      | items_total                           | 500                         |
      | total                                 | 500                         |
      | state                                 | new                         |
      | items[0].quantity                     | 1                           |
      | items[0].unit_price                   | 500                         |
      | items[0].total                        | 500                         |
      | purchase_state                        | completed                   |
      | payment_state                         | awaiting_payment            |
      | metadata.intention                    | bottom_box                  |
      | metadata.source                       | web_version                 |
      | metadata.custom                       | custom value                |
    And the JSON node "metadata" should have 3 elements
    And the JSON node "start_date" should be null
    And the JSON node "token_value" should not be null
    And the JSON node "interval" should be null
    And the JSON node "purchase_completed_at" should not be null
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "items" should have 1 element
    And the JSON node "payments" should have 1 element
    And the JSON node "items[0].created_at" should not be null
    And the JSON node "items[0].updated_at" should not be null
    And the JSON node "_links" should not be null
