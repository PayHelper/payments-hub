Payments Hub
[![Build Status](https://travis-ci.org/PayHelper/payments-hub.svg?branch=master)](https://travis-ci.org/PayHelper/payments-hub) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PayHelper/payments-hub/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PayHelper/payments-hub/?branch=master) 
=============

A free and open-source framework for voluntary payment integration into different publishing channels.

## Prerequisites

This project requires the [OpenSSL](https://www.openssl.org/) library to be installed and PHP >= 7.1.

## Requirements

Check [Symfony Requirements](http://symfony.com/doc/current/reference/requirements.html), first.

**Operating Systems**
- Linux or MacOS

**Web Servers**

Payments Hub can run on Nginx or Apache servers.

For the development purposes we recommend using Symfony's PHP’s built-in web server.

See [Configuring a Web Server](http://symfony.com/doc/current/setup/web_server_configuration.html) section for more details.

**Database**
- PostgreSQL 9.x

## Configuration

Generate the SSH keys to properly use the authentication:

``` bash
mkdir var/jwt
openssl genrsa -out var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
```

## Installation

You need [Composer](https://getcomposer.org/download/) to install PHP dependencies.

Then run the following commands:

```bash
composer install
bin/console doctrine:migrations:migrate
bin/console server:start
```

**Note** If the database does not exist, create it manually or by running command: `bin/console doctrine:database:create`.

Next, open http://127.0.0.1:8000 in your browser and you will see Payments Hub running in the development mode.

## License

See the complete license [here](LICENSE.md).

## Contributors

This project is a Sourcefabric z.ú. and contributors initiative.
