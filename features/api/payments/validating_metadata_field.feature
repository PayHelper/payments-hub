@subscriptions
Feature: Validating subscription's metadata
  In order to provide a valid metadata field
  As a HTTP Client
  I want to make a request against subscription create endpoint

  Scenario: Create subscription and validate not empty metadata field
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
      "method": "directdebit",
      "metadata": {
          "intention":"bottom_box",
          "source":"web_version"
      }
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "metadata" should have "2" elements
    And the JSON nodes should contain:
      | metadata.intention                    | bottom_box                  |
      | metadata.source                       | web_version                 |

  Scenario: Create subscription and validate empty metadata field
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
      "method": "directdebit",
      "metadata": {}
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "metadata" should exist
    And the JSON node "metadata" should not be null
    And the JSON node "metadata" should have "0" elements

  Scenario: Create and validate subscription when metadata field not present
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
    And the JSON node "metadata" should exist
    And the JSON node "metadata" should not be null
    And the JSON node "metadata" should have "0" elements
