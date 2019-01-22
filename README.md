# HoZT

Symfony 4 project

Run `git pull` to update the master branch clone to its latest version.

## Deploy steps

1. Configure your Environment variables
   * Make sure you have the .env file present and configured.
1. Generate composer dependencies for this (prod) environment
   * `composer remove symfony/dotenv`
   * `composer require symfony/dotenv`
1. Install/update vedors
   * `composer install --no-dev --optimize-autoloader`
