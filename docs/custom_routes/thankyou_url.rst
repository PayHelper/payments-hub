How To Change Thank You URL?
============================

The "thank you" URL can be changed by simply setting a ``ph_payum_redirect_thank_you_url`` parameter in
``app/config/parameters.yml`` file. The default value is ``/thank-you`` which is defined by the Payments Hub.

.. code-block:: yaml

    # app/config/parameters.yml
    parameters:
        # ..
        ph_payum_redirect_thank_you_url: '/custom/thanks'

That's it! Now, if the payment was completed successfully or it failed, a user will be redirected to a newly configured URL.
