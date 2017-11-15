How To Change Cancel URL?
=========================

The "cancel" URL can be changed by simply setting a ``ph_payum_redirect_cancel_url`` parameter in
``app/config/parameters.yml`` file. The default value is ``/cancel`` which is defined by the Payments Hub.

.. code-block:: yaml

    # app/config/parameters.yml
    parameters:
        # ..
        ph_payum_redirect_cancel_url: '/custom/cancel'

That's it! Now, if the payment was cancelled, a user will be redirected to a newly configured URL.
