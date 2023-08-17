<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Website CitraKayon

## Requirement
1. PHP 7.4 +
2. Git
3. Composer
4. PostgreSQL

## Installation

1. Clone to your directory.
```bash
$ git clone https://gitlab.com/citra-kayon/backend-cms.git
$ cd backend-cms
```

2. Setup your Virtual Host and point to ```bash /var/www/backend-cms/public ```

3. Setup your .env file

4. Open terminal
```bash
$ cd ~
$ cd /var/www/backend-cms
$ /var/www/backend-cms: composer install
$ /var/www/backend-cms: php artisan migrate
$ /var/www/backend-cms: php artisan storage:link
$ /var/www/backend-cms: php artisan db:seed
```

5. Open your Virtual Host Url. Enjoy.