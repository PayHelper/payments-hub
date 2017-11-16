SEPA Direct Debit Mandate Confirmation Template
===============================================

What is the SEPA Direct Debit Mandate Confirmation template?
------------------------------------------------------------

The SEPA Direct Debit Mandate Confirmation template is the template file which is rendered when the SEPA Direct Debit payment
method using Mollie gateway is used.

Once this payment method is selected/used and the SEPA Direct Debit bank account details are submitted
the SEPA Direct Debit Mandate Confirmation template is rendered where a user needs to confirm the SEPA Direct Debit
Mandate in order to process further recurring payments.

Why to change the SEPA Direct Debit Mandate Confirmation template?
------------------------------------------------------------------

There might be a reason to change that template in case there is a need to display a custom message to the user or to change the
overall template's appearance.

How to override SEPA Direct Debit Mandate Confirmation template?
----------------------------------------------------------------

The default template location is `src/PH/Bundle/PayumBundle/Resources/views/Action/sepa_mandate_confirmation.html.twig`_.

To override the template, just copy the ``sepa_mandate_confirmation.html.twig`` template from the Payum bundle to
``app/Resources/PHPayumBundle/views/Action/sepa_mandate_confirmation.html.twig`` (the ``app/Resources/PHPayumBundle`` directory won't exist,
so you'll need to create it). You're now free to customize the template.

.. code-block:: twig

    {# app/Resources/PHPayumBundle/views/Action/sepa_mandate_confirmation.html.twig #}

    <h3>SEPA Direct Debit Mandate</h3>

    <p>By providing your IBAN and confirming this payment, you are authorizing "Your Company Name" and Mollie,
        our payment service provider, to send instructions to your bank to debit your account and your bank to debit
        your account in accordance with those instructions.
        You are entitled to a refund from your bank under the terms and conditions of your agreement with your bank.
            A refund must be claimed within 8 weeks starting from the date on which your account was debited.</p>

    <h4>Creditor details:</h4>
    <table border="1">
        <tr>
            <th>Creditor Identifier</th>
            <td>Your creditor id</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>Creditor name</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>Creditor Address</td>
        </tr>
    </table>

    <h4>Customer details:</h4>
    <table border="1">
        <tr>
            <th>IBAN</th>
            <td>{{ model.details.consumerAccount }}</td>
        </tr>
        <tr>
            <th>Holder name</th>
            <td>{{ model.details.consumerName }}</td>
        </tr>
    </table>

    <p>Date of signing: {{ model.signatureDate }}</p>


    <form method="post" action="{{ actionUrl }}">
        <input type="hidden" name="mandate_id" value="{{ model.id }}"/>

        <button type="submit">Confirm</button>
    </form>

    <a href="{{ cancelUrl }}">Go Back</a>

As you can see above, the ``actionUrl`` variable is defined which should be used as a form action. This variable
defines an action URL to which the submitted form data will be sent.

The ``cancelUrl`` variable prints the payment cancellation URL. If a user decides to go to that link,
the payment process will be cancelled and a :doc:`Payment Cancellation Template <cancel_template>` will be rendered.

There is also a ``model`` variable which is an array containing the details of the currently processed data
from where you can get info about the currently submitted mandate.

.. note::

    You can use a ``dump`` (e.g. ``{{ dump(model) }}``) function to dump the value of ``model`` variable to find out what keys and values it contains.
    Note that ``dump`` function can be used only in the development environment.

That's it! A new template will be rendered whenever the SEPA Direct Debit using Mollie gateway will be selected as
a payment method and when the bank account details form will be submitted.

.. _`src/PH/Bundle/PayumBundle/Resources/views/Action/sepa_mandate_confirmation.html.twig`: https://github.com/PayHelper/payments-hub/blob/master/src/PH/Bundle/PayumBundle/Resources/views/Action/sepa_mandate_confirmation.html.twig
.. _`Forms`: https://symfony.com/doc/current/forms.html
.. _`How to Customize Form Rendering`: https://symfony.com/doc/current/form/form_customization.html
