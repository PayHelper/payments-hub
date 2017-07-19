@webhooks
Feature: Editing existing webhook
  In order to edit existing webhook available in the system
  As a HTTP Client
  I want to be able to make a request to webhook edit endpoint

  Scenario: Edit a single webhook by id
    Given I am authenticated as "admin"
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
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "PATCH" request to "/api/v1/webhooks/1" with body:
    """
    {
      "url": "http://edit-example.com/my-webhook"
    }
    """
    Then the response status code should be 204
    And the response should be empty
    Then I send a "GET" request to "/api/v1/webhooks/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "url" should be equal to "http://edit-example.com/my-webhook"
