Exception Page Template
=======================

What is the exception template?
-------------------------------

The "exception template" is the template file which is rendered once there is an unexpected exception being thrown by one of the payment gateways.

Why to change the exception template?
-------------------------------------

There might be a reason to change that template in case there is a need to display a custom message to the user or to change the
overall template's appearance.

How to override exception template?
-----------------------------------

The default template location is `src/PH/Bundle/PayumBundle/Resources/views/exception.html.twig`_.

To override the template, just copy the ``exception.html.twig`` template from the Payum bundle to
``app/Resources/PHPayumBundle/views/exception.html.twig`` (the ``app/Resources/PHPayumBundle`` directory won't exist,
so you'll need to create it). You're now free to customize the template.

.. code-block:: twig

    {# app/Resources/PHPayumBundle/views/exception.html.twig #}

    <h1>My custom exception template.<h1>

That's it! A new template will be rendered whenever there will be an unexpected exception thrown.

.. _`src/PH/Bundle/PayumBundle/Resources/views/exception.html.twig`: https://github.com/PayHelper/payments-hub/blob/master/src/PH/Bundle/PayumBundle/Resources/views/exception.html.twig
