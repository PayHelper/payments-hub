@public_subscriptions
Feature: Validating subscription's start date
  In order to be able to create a new recurring subscription with a proper start date
  As a HTTP Client
  I want to be prevented from typing wrong start date

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

  Scenario: Creating a new recurring subscription with the 15th day of start date
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
          "day": "15",
          "year": "2017"
       },
      "method":"sepa"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON

  Scenario: Creating a new recurring subscription with the 1st day of start date
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
          "day": "1",
          "year": "2017"
       },
      "method":"sepa"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON

  Scenario: Creating new subscription with the upcoming month of the given one in start date
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
          "month": "11",
          "day": "1",
          "year": "2017"
       },
      "method":"sepa"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON

  Scenario: Creating new subscription with the next month of the upcoming month in start date
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
          "month": "12",
          "day": "1",
          "year": "2017"
       },
      "method":"sepa"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
