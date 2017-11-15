Payment Cancellation Template
=============================

What is the cancellation template?
----------------------------------

The "cancellation template" is the template file which usually renders a payment's cancellation text to the user.
A user is redirected to the "cancel URL" after the payment was cancelled using one of the payment gateways.
The content of that file is then rendered.

Why to change the cancellation template?
----------------------------------------

There might be a reason to change that template in case there is a need to display a custom message to the user or to change the
overall template's appearance.

How to override cancellation template?
--------------------------------------

The default template location is `src/PH/Bundle/CoreBundle/Resources/views/cancel.html.twig`_.

To override the template, just copy the ``cancel.html.twig`` template from the Core bundle to
``app/Resources/PHCoreBundle/views/cancel.html.twig`` (the ``app/Resources/PHCoreBundle`` directory won't exist,
so you'll need to create it). You're now free to customize the template.

.. code-block:: twig

    {# app/Resources/PHCoreBundle/views/cancel.html.twig #}

    <h1>The payment has been cancelled.<h1>
    {% if app.request.get('token') %}
        <div style="color: #3D7700">Transaction id {{ app.request.get('token') }}</div>
    {%  endif %}

The ``token`` query parameter is automatically appended to the "cancel URL", thus as you can see above you can
read it in the "cancel template" to inform user about the cancelled transaction identifier.

That's it! A new template will be rendered whenever the payment process will be cancelled.

Lear More
---------

.. toctree::
    :hidden:

    /custom_routes/index

.. include:: /custom_routes/map.rst.inc

.. _`src/PH/Bundle/CoreBundle/Resources/views/cancel.html.twig`: https://github.com/PayHelper/payments-hub/blob/master/src/PH/Bundle/CoreBundle/Resources/views/cancel.html.twig
