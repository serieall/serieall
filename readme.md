# Série-All
-----------

## Install

Prerequisite: 
- Linux system
- Git installed
- Redis installed 
- Docker installed (see https://docs.docker.com/engine/install/)


To install Série-All : 

```
apt-get install php php-gd php-curl php-mbstring php-xml php-mysql php-bcmath php-apcu-bc composer
git clone https://github.com/serieall/serieall.git
cd serieall
composer install
docker run --name mysql-serieall-dev -p 3306:3306 -v /var/lib/mysql/serieall-dev:/var/lib/mysql -e MYSQL_DATABASE="serieall" -e MYSQL_ROOT_PASSWORD="serieall" -d mysql:5.7
cp .env_example .env
php artisan key:generate
php artisan migrate --seed
```

Check .env file to ajust to your configuration

## Development

To launch the application, you can use : 
```
php artisan serve
php artisan queue:work
```

