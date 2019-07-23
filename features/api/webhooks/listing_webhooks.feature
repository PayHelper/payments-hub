@webhooks
Feature: Listing webhooks
  In order to see available webhooks in the system
  As a HTTP Client
  I want to make a request against webhook list endpoint

  Scenario: List webhooks
    Given I am authenticated as "admin"
    Given I am want to get JSON
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/webhooks/" with body:
    """
    {
      "enabled": 1,
      "url": "http://example.com/my-webhook"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON

    Given I am authenticated as "admin"
    Given I am want to get JSON
    And I send a "GET" request to "/api/v1/webhooks/"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 1 element
