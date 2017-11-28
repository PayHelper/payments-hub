How to Run Tests?
=================

.. note::

    Running tests will only work in the development environment.

The behaviour of the application is covered using `Behat`_ scenarios.

Just run the following command:

.. code-block:: bash

    bin/behat --strict --no-interaction -vvv -f progress

All Behat scenarios are located inside ``features`` directory inside Payments Hub repository.

.. _`Behat`: http://behat.org/
