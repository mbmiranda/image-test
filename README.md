image-test
==========

Images uploader test app

Installation:

1. install composer
```
curl -s http://getcomposer.org/installer | php
```

2. install project dependencies
```
php composer.phar install
```

3. configure apache virtual host:
```
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/image-test"
    ServerName image-test.local
</VirtualHost>
```

4. configure hosts file:
```
127.0.0.1 image-test.local
```

5. run the application:
```
http://image-test.local/
```