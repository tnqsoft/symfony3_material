# README #

This README would normally document whatever steps are necessary to get your application up and running.

### Setup Develop Environment
#### Prepare environment
- Server Local Xampp
- Symfony CLI (http://symfony.com)
- Php packager management Composer https://getcomposer.org/
- Source management Git Bash https://git-scm.com/download/win
- Continuous delivery Capistrano (Required Ruby)
- MySQL Client Sqlyog or PHPMyadmin
- IDE Atom for PHP coding

#### Virtual Host Local
```
<VirtualHost *:80>
    ServerName symfony3-material.local
    ServerAlias symfony3-material.local    
    SetEnv sfEnv dev

    #For Linux
    #DocumentRoot /home/nntuan/labs/symfony3-material-project/web
    #For Windows
    DocumentRoot D:/projects/symfony3-material-project/web

    #For Linux
    #<Directory /home/nntuan/labs/symfony3-material-project/web>
  	#For windows
    <Directory D:/projects/symfony3-material-project/web>
        #Options Indexes FollowSymLinks
        AllowOverride all
        Require all granted
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ app.php [QSA,L]
            RewriteCond %{HTTP:Authorization} ^(.*)
            RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
        </IfModule>
    </Directory>
    #For Ubuntu apache config
    #ErrorLog ${APACHE_LOG_DIR}/error-symfony3-material.log
    #CustomLog ${APACHE_LOG_DIR}/access-symfony3-material.log combined

    #For Xampp windows config
    ErrorLog "logs/error-symfony3-material.log"
    CustomLog "logs/access-symfony3-material.log" combined
</VirtualHost>
```

#### Virtual Host PROD
```
<VirtualHost *:80>
    ServerAdmin tuanquynh0508@gmail.com
    ServerName symfony3-material.com
    ServerAlias symfony3-material.com
    DocumentRoot /data/www/symfony3-material/current/web
    SetEnv sfEnv prod
    <Directory /data/www/symfony3-material/current/web>
        Options +FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ app.php [QSA,L]
            RewriteCond %{HTTP:Authorization} ^(.*)
            RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
        </IfModule>
    </Directory>

    ErrorLog logs/www/symfony3-material-error.log
    CustomLog logs/www/symfony3-material-access.log combined
</VirtualHost>
```

### Add Hosts File
```
127.0.0.1 symfony3-material.local
```

### Test online
http://symfony3-material.com

#### Deploy
```
cap prod deploy
```

## 2. Command Use
```
#View Log File
tail -f -n 100 /var/log/apache2/symfony3-material-access.log
tail -f -n 100 /var/log/apache2/symfony3-material-error.log

php bin/console

php bin/console cache:clear --env=dev

php bin/console assets:install --symlink web

php bin/console assetic:dump --env=dev

php bin/console doctrine:migrations:diff --env=dev

php bin/console doctrine:migrations:migrate 20170418031634 --env=dev

php bin/console doctrine:migrations:generate --env=dev

php bin/console generate:bundle --namespace=Tnqsoft/CommonBundle --dir=src --format=annotation --no-interaction

php bin/console doctrine:generate:entities AppBundle/Entity/User

php bin/console doctrine:schema:update --force --env=dev

#https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/usage.html
php bin/console fos:js-routing:dump --env=dev

#https://github.com/willdurand/BazingaJsTranslationBundle/blob/master/Resources/doc/index.md
php app/console bazinga:js-translation:dump [target] [--format=js|json] [--merge-domains]
```
