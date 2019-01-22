# HoZT

Symfony 4 project

Run `git pull` to update the master branch clone to its latest version.

## Deploy steps

A summary based on https://symfony.com/doc/current/deployment.html

1. Configure your Environment variables
   * Make sure you have the .env file present and configured properly (and no .env.local file present!!).
1. Generate composer dependencies for this (prod) environment
   * `composer require symfony/dotenv`
1. Install/update vendors
   * `export APP_ENV=prod`
   * `composer install --no-dev --optimize-autoloader`
1. Clear symfony cache
   * `APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear`
1. Clear symfony cache
   * `APP_ENV=prod APP_DEBUG=0 php bin/console cache:warmup`
