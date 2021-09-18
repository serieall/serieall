# Série-All
-----------

## Prerequisites

- Linux system
- Git installed
- Composer installed
- Docker installed (see https://docs.docker.com/engine/install/)

```bash
# Install PHP and PHP modules
apt-get install php php-gd php-curl php-mbstring php-xml php-mysql php-bcmath php-apcu-bc composer

# Start database and redis
make start-db
make start-redis
```

## Install
```
git clone https://github.com/serieall/serieall.git
cd serieall
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Check .env file to adjust to your configuration.

## Development

To launch the application, you can use : 
```
php artisan serve
php artisan queue:work
```

## Linter

The linter used is php-cs-fixer. You can integrate it with most code editors (check [here](https://github.com/FriendsOfPHP/PHP-CS-Fixer)).
If you want to check the linting of the code you can run:
```bash
make lint
```

If you want PHP CS Fixer to fix everything for you, just run:
```bash
make lint-fix
```

## Tests

You can run unit tests with this command:
```bash
make tests
```