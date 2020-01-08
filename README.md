Binnus Wonosobo Web Development
=================================

Pre Installation
---------------------------------
1. Download git (di sini)[https://git-scm.com/download/win]
2. ``git clone ``
2. Download composer
```bash
cd 
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'baf1608c33254d00611ac1705c1d9958c817a1a33bce370c0595974b342601bd80b92a3f46067da89e3b06bff421f182') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Installation
---------------------------------
1. 
2. ``cd project_dir``
3. ``composer update && composer install``
4. ``php artisan migrate`` to run database migration
5. ``php artisan db:seed``