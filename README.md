payments--hub
=============

Prerequisites
-------------

This project requires the [OpenSSL](https://www.openssl.org/) library to be installed.

Configuration
-------------

Generate the SSH keys to properly use the authentication:

``` bash
mkdir var/jwt
openssl genrsa -out var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
```