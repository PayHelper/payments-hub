SEPA Direct Debit Bank Account Template
=======================================

What is the SEPA Direct Debit Bank Account template?
----------------------------------------------------

The "SEPA Direct Debit Bank Account template" is the template file which is rendered when the SEPA Direct Debit payment
method using Mollie gateway is used.

Once this payment method is selected/used the SEPA Direct Debit Bank Account template is rendered so the user can enter
bank account details in order to process further payment.

Why to change the SEPA Direct Debit Bank Account template?
----------------------------------------------------------

There might be a reason to change that template in case there is a need to display a custom message to the user or to change the
overall template's appearance.

How to override SEPA Direct Debit Bank Account template?
--------------------------------------------------------

The default template location is `src/PH/Bundle/PayumBundle/Resources/views/Action/obtain_sepa_bank_account.html.twig`_.

To override the template, just copy the ``obtain_sepa_bank_account.html.twig`` template from the Payum bundle to
``app/Resources/PHPayumBundle/views/Action/obtain_sepa_bank_account.html.twig`` (the ``app/Resources/PHPayumBundle`` directory won't exist,
so you'll need to create it). You're now free to customize the template.

.. note::

    This documentation assumes you have already a working knowledge of the Symfony
    Forms. If you're not familiar with Symfony Forms, please start with
    reading the `Forms`_ and `How to Customize Form Rendering`_ from the Symfony documentation.

.. code-block:: twig

    {# app/Resources/PHPayumBundle/views/Action/obtain_sepa_bank_account.html.twig #}

    <form method="post" action="{{ actionUrl }}">
        {{ form_row(form) }}

        {{ form_rest(form) }}

        <input type="submit" value="Submit" />
    </form>

As you can see above, the ``actionUrl`` variable is defined which should be used as a form action. This variable
defines an action URL to which the submitted form data will be sent.

There is also a ``form`` variable which represents a Symfony Form object which can be customized according to the
`How to Customize Form Rendering`_ from the Symfony documentation.

That's it! A new template will be rendered whenever the SEPA Direct Debit using Mollie gateway will be selected as
a payment method.

.. _`src/PH/Bundle/PayumBundle/Resources/views/Action/obtain_sepa_bank_account.html.twig`: https://github.com/PayHelper/payments-hub/blob/master/src/PH/Bundle/PayumBundle/Resources/views/Action/obtain_sepa_bank_account.html.twig
.. _`Forms`: https://symfony.com/doc/current/forms.html
.. _`How to Customize Form Rendering`: https://symfony.com/doc/current/form/form_customization.html