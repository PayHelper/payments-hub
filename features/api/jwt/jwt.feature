@jwt
Feature: Obtaining JWT token
  In order to perform requests against API
  As a HTTP Client
  I want to be able to obtain JWT token

  Scenario: Obtaining jwt token
    When I add "Content-Type" header equal to "application/json"
    And I send a POST request to "/api/v1/login_check" with body:
    """
      {
        "username":"admin",
        "password":"admin"
      }
    """
    Then the response status code should be 200
    And the JSON node "token" should not be null

  Scenario: Obtaining JWT token with fake credentials
    When I add "Content-Type" header equal to "application/json"
    And I send a POST request to "/api/v1/login_check" with body:
    """
      {
        "username":"fake",
        "password":"fake"
      }
    """
    Then the response status code should be 401
