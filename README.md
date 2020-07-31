# Currency Task

Built in Laravel
## Getting Started

First, clone the repository and cd into it:

```bash
git clone https://github.com/sultansagi/country-manager-backend
cd country-manager-backend
```

Next, update and install with composer:

```bash
composer update --no-scripts
composer install
```

Next, set configs, set Database:

```bash
php artisan key:generate
cp .env.example .env
```

Lastly, run the following command to migrate your database using the credentials:

```bash
php artisan migrate
```

You should now be able to start the server using `php artisan serve`

Also we can check PHPUnit tests, by running:

```bash
vendor/bin/phpunit
```

## Contributing

Feel free to contribute to anything.