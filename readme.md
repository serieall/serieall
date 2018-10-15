# Série-All V2

## Installation en mode développement

Pour installer la V2 : 

```
apt-get install php php-curl php-mbstring php-xml php-mysql php-bcmath composer
git clone https://github.com/Youkoulayley/AveDeux.git
cd AveDeux
composer install
docker run --name mysql-serieall-dev -p 3306:3306 -v /var/lib/mysql/serieall-dev:/var/lib/mysql -e MYSQL_DATABASE="serieall" -e MYSQL_ROOT_PASSWORD="serieall" -d mysql:5.7
php artisan key:generate
php artisan migrate --seed
php artisan serve
php artisan queue:work
```

## Installation en mode production (soon)