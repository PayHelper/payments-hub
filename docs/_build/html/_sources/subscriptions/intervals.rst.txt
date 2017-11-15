Subscription’s intervals
========================

By default, there are three intervals configured as listed below:

- Monthly (1 month)
- Quarterly (3 months)
- Yearly (1 year)

Intervals are only used when the subscription of type ``recurring`` is used.
For ``non-recurring`` subscription this field is ignored.

Why to change the subscription’s intervals?
-------------------------------------------

There might be a reason to customize the subscription's intervals to your own needs in order to provide different options
to end users.

How to change the subscription’s intervals?
-------------------------------------------

The default intervals are configured in the ``app/config/parameters.yml`` file as an array under the
``subscription_intervals`` parameter:

.. code-block:: yaml

    # app/config/parameters.yml
    parameters:
        # ..
        subscription_intervals:
            Monthly: 1 month
            Quarterly: 3 months
            Yearly: 1 year


To change the intervals, simply change the value of the ``subscription_intervals`` parameter inside ``app/config/parameters.yml`` file:

.. code-block:: yaml

    # app/config/parameters.yml
    parameters:
        # ..
        subscription_intervals:
            Monthly: 1 month
            Quarterly: 3 months
            Half-yearly: 6 months
            Yearly: 1 year

Note that this is a key-value array where key is a label and the value is the real interval value that is used by the
payment gateway. The value can be either:
1 month, 2 months, 4 months, 2 years etc.

That's it! New intervals will be now available in the system.

.. _`src/PH/Bundle/PayumBundle/Resources/views/exception.html.twig`: https://github.com/PayHelper/payments-hub/blob/master/src/PH/Bundle/PayumBundle/Resources/views/exception.html.twig
