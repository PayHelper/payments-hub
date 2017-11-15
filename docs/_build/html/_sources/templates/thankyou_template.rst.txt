Payment Thank Tou Template
==========================

What is the payment thank you template?
---------------------------------------

The "payment thank you template" is the template file which usually renders a "thank you" text to the user.
A user is redirected to the "thank you URL" after the payment was completed or failed using one of the payment gateways.
The content of that file is then rendered.

Why to change the payment thank you template?
---------------------------------------------

There might be a reason to change that template in case there is a need to display a custom message to the user or to change the
overall template's appearance.

How to override thank you template?
-----------------------------------

The default template location is `src/PH/Bundle/CoreBundle/Resources/views/thankYou.html.twig`_.

To override the template, just copy the ``thankYou.html.twig`` template from the Core bundle to
``app/Resources/PHCoreBundle/views/thankYou.html.twig`` (the ``app/Resources/PHCoreBundle`` directory won't exist,
so you'll need to create it). You're now free to customize the template.

.. code-block:: twig

    {# app/Resources/PHCoreBundle/views/thankYou.html.twig #}

    <h1>Thank you.<h1>
    {% if app.request.get('token') %}
        <div style="color: #3D7700">Transaction id {{ app.request.get('token') }}</div>
    {%  endif %}

The ``token`` query parameter is automatically appended to the "thank you URL", thus as you can see above you can
read it in the "thank you template" to inform user about the transaction identifier.

That's it! A new template will be rendered whenever the payment process will be completed or failed.

Even if the the payment process failed, there still will be a redirect to "thank you" url.

Lear More
---------

.. toctree::
    :hidden:

    /custom_routes/index

.. include:: /custom_routes/map.rst.inc

.. _`src/PH/Bundle/CoreBundle/Resources/views/thankYou.html.twig`: https://github.com/PayHelper/payments-hub/blob/master/src/PH/Bundle/CoreBundle/Resources/views/thankYou.html.twig
