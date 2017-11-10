@subscriptions
Feature: Prevent creating a subscription if a payment method does not support payments of the selected subscription type
  In order to buy either a recurring or non-recurring subscription
  As a HTTP Client
  I want to make a request against subscription create endpoint

  Scenario: Create a new recurring subscription when a payment method which does not support recurring payments is defined
    Given I am authenticated as "admin"
    And the system has a payment method "Offline" with a code "cash_on_delivery"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": "2017-10-10",
       "method": "cash_on_delivery"
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | errors.children.method.errors[0] | This value is not valid. |

  Scenario: Create a new non-recurring subscription when a payment method which does not support non-recurring payments is defined
    Given I am authenticated as "admin"
    And the system has a payment method "SEPA Direct Debit" with a code "directdebit" and a "directdebit" method using Mollie gateway which supports recurring
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/subscriptions/" with body:
    """
    {
      "amount":500,
      "currency_code":"USD",
      "type":"non-recurring",
       "method": "directdebit"
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | errors.children.method.errors[0] | This value is not valid. |
