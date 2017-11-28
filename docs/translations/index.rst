How to Translate the Payments Hub?
==================================

.. note::

    From now on, you can also help translate the Payments Hub using Crowdin platform https://crwd.in/payments-hub.

There are just a few translation files which contain the translations strings.

- `messages.en.yml`_ - contains generic payment translation strings
- `PayumBundle.en.yml`_ - contains translation strings related to the payment gateways
- `validators.en.yml`_ - contains translation strings related to the validation

To translate these files, for example, to German language, just copy and paste them into the same directory by changing the ``en`` to ``de`` in the file name
(e.g. ``messages.de.yml``, ``PayumBundle.de.yml``), where ``de`` is the language code according to
the `ISO 639-1`_ and the `ISO 3166-1 alpha-2`_ standards.

Then, just change the English values of the translation parameters to German.

Last but not least, set the ``locale`` parameter in ``app/config/parameters.yml`` file to ``de`` in order to load
newly translated strings.

.. code-block:: yaml

    # app/config/parameters.yml
    parameters:
        # ..
        locale: de


.. note::

    You might need to clear the cache so the new files with the translations strings can be loaded properly. Just run command
    ``php app/console cache:clear``.


Finally, commit these newly created files and `open a Pull Request`_ to the `Payments Hub Repository`_.

.. _`messages.en.yml`: https://github.com/PayHelper/payments-hub/blob/master/src/PH/Bundle/PayumBundle/Resources/translations/messages.en.yml
.. _`PayumBundle.en.yml`: https://github.com/PayHelper/payments-hub/blob/master/src/PH/Bundle/PayumBundle/Resources/translations/PayumBundle.en.yml
.. _`validators.en.yml`: https://github.com/PayHelper/payments-hub/blob/master/src/PH/Bundle/PayumBundle/Resources/translations/validators.en.yml
.. _`ISO 639-1`: https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
.. _`ISO 3166-1 alpha-2`: https://en.wikipedia.org/wiki/ISO_3166-1#Current_codes
.. _`open a Pull Request`: https://help.github.com/articles/creating-a-pull-request/
.. _`Payments Hub Repository`: https://github.com/PayHelper/payments-hub
