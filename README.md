Payments Hub
[![Build Status](https://travis-ci.org/PayHelper/payments-hub.svg?branch=master)](https://travis-ci.org/PayHelper/payments-hub) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PayHelper/payments-hub/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PayHelper/payments-hub/?branch=master) [![StyleCI](https://styleci.io/repos/92825992/shield?branch=master)](https://styleci.io/repos/92825992)
=============

A free and open-source framework for voluntary payment integration into different publishing channels.

## Documentation

Documentation is available at [payments-hub.readthedocs.io](https://payments-hub.readthedocs.io).

## Prerequisites

Read the [Prerequisites](https://payments-hub.readthedocs.io/en/latest/installation/prerequisites.html) section to find out more.

## Requirements

Read the [Requirements](https://payments-hub.readthedocs.io/en/latest/installation/requirements.html) section to see what is required before starting.

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

See the complete license [here](LICENSE).

## Contributors

This project is a Sourcefabric z.ú. and contributors initiative.
