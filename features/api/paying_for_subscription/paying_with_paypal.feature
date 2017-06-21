@pay_for_subscription
Feature: Paying with Paypal during checkout
  In order to get an access
  As a HTTP Client
  I want to be able to pay with PayPal Express Checkout

  @createSchema
  @dropSchema
  Scenario: Successful payment
    Given the system has a payment method "PayPal" with a code "paypal" and Paypal Express Checkout gateway
    And I added product "PHP T-Shirt" to the cart
    And I have proceeded selecting "PayPal" payment method
    When I confirm my order with paypal payment
    And I sign in to PayPal and pay successfully
    Then I should be notified that my payment has been completed
    And I should see the thank you page