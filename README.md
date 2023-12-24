## Wallet Micro Service

This project is written using the Laravel framework and docker(sail). and has 2 web services.

The Postman file for requests along with all possible responses is available at the root of the project.

After cloning the project, run the following commands in the root of the project to start the process:

```php
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

Then :

```php
cp .env.example .env
```

And after that:

```php
./vendor/bin/sail up -d
```

You might need a VPN or changing DNS to be able to get docker images.

Next with this command you can go inside the container:

```php
./vendor/bin/sail shell
```

Run the following command when you are inside:

```php
php artisan key:generate
```

Until here these were standard commands for running the laravel project on docker(using sail),
after these run this command:

```php
php artisan setup
```

Every time you run this command, it will rerun the migrations and add some users to make it easier to test.

You can run tests inside container with this command:

```php
php artisan test
```

Or with this command outside the container:

```php
./vendor/bin/sail php artisan test
```
There is also another command to see total amount of transactions:
```php
php artisan transaction:report
```
