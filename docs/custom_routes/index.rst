Custom Redirect URLs
====================

Payments Hub allows to change the redirect URLs that are used by the payment gateways.
By defaut, there are two main redirect URLs:

- thank you URL
- cancel URL

Once a user chooses the payment method and pays for the subscription, Payment Hub communicates with the
remote gateway. Next, the remote gateway redirects back a user to the Payments Hub and then the internal
redirect to the "thank you" URL is done. In case of the successful or failed payment, a user is redirected to the "thank you" URL.
In case of cancellation, a user is redirected to the "cancel" URL.

These URLs can be changed so, for example, a user can be redirected to a different view on a different server.

.. toctree::
    :hidden:

    thankyou_url
    cancel_url

.. include:: /custom_routes/map.rst.inc
