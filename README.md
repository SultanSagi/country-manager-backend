# Country converter

Built in Laravel. There are three types of files (json, csv, xml) that list countries and their capitals. It is necessary to develop an interface with which it would be possible to download
                  this file, display its contents on the screen, edit and download the edited version in any of the above formats.

## Features
- CRUD for countries
- Ability to import from files (xml, json, csv) to the database
- On the editing page there is a "download" button and a choice of a download format in the form of a dropdown with options (json, csv, xml)
- Command to convert a file to another

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
A console command that will convert lists from one format to another:
```bash
php artisan convert:countries --input-file=countries.xml --output-file=countries.json
```
## Contributing

Feel free to contribute to anything.