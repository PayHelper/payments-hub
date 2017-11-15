Installation
============

If you don't have Composer installed in your computer, start by
:doc:`installing Composer globally </setup/composer>`.

Clone the repository and install vendors using Composer:

.. note::

    Before installing dependencies, make sure the :doc:`SSH keys needed for the API authentication are generated <configuration>`.

Then run the following command:

.. code-block:: bash

    composer install

When all dependencies are installed, you will be asked to fill the ``parameters.yml`` file which needs to be
completed before continuing.

Then create the database schema:

.. note::

    If the database does not exist, create it manually or by running command: ``bin/console doctrine:database:create``.

Run:

.. code-block:: bash

    bin/console doctrine:migrations:migrate

and start the Payments Hub using built-in PHP server:

.. code-block:: bash

    bin/console server:start

Next, open ``http://127.0.0.1:8000`` in your browser and you will see Payments Hub running in the development mode.

For the production, you will need to configure the vhost using Nginx or Apache and run the project there, instead of using
the built-in PHP server.
