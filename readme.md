# Série-All V2

## Installation en mode développement

Pour installer la V2 : 

```
apt-get install php php-curl php-mbstring php-xml php-mysql php-bcmath composer
git clone https://github.com/Youkoulayley/AveDeux.git
cd AveDeux
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
php artisan queue:work
```

## Installation en mode production (soon)