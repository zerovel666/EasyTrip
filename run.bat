Invoke-WebRequest -Uri https://getcomposer.org/installer -OutFile composer-setup.php
php composer-setup.php
Remove-Item composer-setup.php
php composer.phar install
php artisan serve