Requirements
============

Firstly, check `Symfony Requirements`_.

Operating Systems
-----------------

- Linux or MacOS

Web Servers
-----------

Payments Hub can run on Nginx or Apache servers.

For the development purposes we recommend using Symfony's PHP’s built-in web server.

See `Configuring a Web Server`_ section for more details.

Databases
---------

- PostgreSQL 9.x
- MySQL 5.x

By default, the PostgreSQL (``pdo_pgsql``) driver is enabled.

.. tip::

    To use MySQL (``pdo_mysql`` driver), just simply set the value of ``database_driver`` parameter to ``pdo_mysql`` in ``app/config/parameters.yml``.

.. _`Symfony Requirements`: https://symfony.com/doc/current/reference/requirements.html
.. _`Configuring a Web Server`: http://symfony.com/doc/current/setup/web_server_configuration.html
