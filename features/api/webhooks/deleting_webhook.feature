@webhooks
Feature: Deleting existing webhook
  In order to delete a webhook available in the system
  As a HTTP Client
  I want to be able to delete existing webhook

  @createSchema
  @dropSchema
  Scenario: Delete a single webhook by id
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/webhooks/" with body:
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
    And I send a "DELETE" request to "/webhooks/1"
    Then the response status code should be 204
    And the response should be empty
