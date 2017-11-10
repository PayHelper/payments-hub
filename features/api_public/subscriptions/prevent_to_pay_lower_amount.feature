@public_subscriptions
Feature: Preventing to pay lower amount than the minimum
  In order to be not able to pay less amount than the defined one
  As a HTTP Client
  I want to be prevented from typing wrong amount

  Scenario: Not being able to pay less than the defined minimum amount
    Given the system has a payment method "Offline" with a code "cash_on_delivery"
    When I add "Authorization" header equal to null
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/public-api/v1/subscriptions/" with body:
    """
    {
      "amount":400,
      "currency_code":"USD",
      "interval":"1 month",
      "type":"recurring",
      "start_date": "2017-10-10"
    }
    """
    Then the response status code should be 400
    And the response should be in JSON
