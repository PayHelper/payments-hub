@subscriptions
Feature: Listing available subscriptions
  In order to see available subscriptions in the system
  As a HTTP Client
  I want to make a request against subscriptions list endpoint

  Scenario: List subscriptions
    Given I am authenticated as "admin"
    And the system has also a new subscription priced at "$50"
    And the system has also a new subscription priced at "$300"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/api/v1/subscriptions/"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 2 elements

  Scenario: List subscriptions by metadata
    Given I am authenticated as "admin"
    And the system has also a new subscription priced at "$30"
    And the system has also a new subscription priced at "$50"
    And this subscription should have metadata "intention" with value "top_box"
    And the system has also a new subscription priced at "$300"
    And this subscription should have metadata "intention" with value "bottom_box"
    And this subscription should have metadata "name" with value "premium_content"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/api/v1/subscriptions/"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 3 elements

    Given I am authenticated as "admin"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/api/v1/subscriptions/?criteria[metadata.intention]=bottom_box"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 1 element

    Given I am authenticated as "admin"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/api/v1/subscriptions/?criteria[metadata.intention]=bottom_box,top_box"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 2 elements

    Given I am authenticated as "admin"
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/api/v1/subscriptions/?criteria[metadata.name]=premium_content"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "_embedded.items" should have 1 element
