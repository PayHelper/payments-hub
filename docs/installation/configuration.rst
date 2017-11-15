Configuration
=============

Generate the SSH keys to properly use the API authentication:

.. code-block:: bash

    mkdir var/jwt
    openssl genrsa -out var/jwt/private.pem -aes256 4096
    openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem

The generated keys will be needed during the :doc:`installation <install>` where you will need to fill the ``parameters.yml`` file
configuration.
