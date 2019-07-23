@webhooks
Feature: Getting a single existing webhook
  In order to list a single existing webhook available in the system
  As a HTTP Client
  I want to be able to make a request to webhook show endpoint

  Scenario: Get a single webhook by id
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
    Then I send a "GET" request to "/api/v1/webhooks/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "enabled" should be equal to "true"
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "_links" should not be null
