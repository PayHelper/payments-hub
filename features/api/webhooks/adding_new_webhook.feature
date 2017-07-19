@webhooks
Feature: Adding a new webhook
  In order to interact easily with 3rd party apps
  As a HTTP Client
  I want to make a request against webhook create endpoint

  Scenario: Add a new webhook
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
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "enabled" should be equal to "true"
    And the JSON node "created_at" should not be null
    And the JSON node "updated_at" should not be null
    And the JSON node "_links" should not be null
