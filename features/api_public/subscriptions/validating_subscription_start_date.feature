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
      "start_date": "2017-10-22"
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
      "start_date": "2017-09-10"
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
      "start_date": "2018-10-10"
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
      "start_date": "2017-10-15",
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
      "start_date": "2017-10-01",
      "method":"sepa"
    }
    """
    Then the response status code should be 400
    And the response should be in JSON

  Scenario: Creating new subscription with the upcoming month in start date
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
      "start_date": "2017-11-01",
      "method":"sepa"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON

  Scenario: Creating new subscription with the 15th day of upcoming month in start date
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
      "start_date": "2017-11-15",
      "method":"sepa"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
