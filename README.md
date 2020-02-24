Binnus Wonosobo Web Development
=================================

Pre Installation
---------------------------------
1. Download git [di sini](https://git-scm.com/download/win) dan install
2. ``git clone https://github.com/fatkhur1960/binnus-dev.git``
2. Download composer
```bash
cd binnus-dev
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'baf1608c33254d00611ac1705c1d9958c817a1a33bce370c0595974b342601bd80b92a3f46067da89e3b06bff421f182') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Installation
---------------------------------
1. ``cd binnus-dev``
2. Buka file `.env` 
```bash
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead #ganti nama database
DB_USERNAME=homestead #ganti username database
DB_PASSWORD=secret #ganti password databse
```
3. ``composer update && composer install``
4. Lalu jalankan ``php artisan migrate``
5. ``php artisan db:seed --class=RoleTableSeeder``
6. Jalankan web dengan ``php artisan serve``
7. default login user `user: admin@local pass: admin`