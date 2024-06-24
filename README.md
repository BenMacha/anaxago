ANAXAGO Technical Test
========================

The "ANAXAGO Technical Test" is a refactoring exercise for back-end developers.


Installation
------------

1. install composer package

```shell
composer install
```

3. install database
```shell
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

4. install jwt cert
```shell
php bin/console lexik:jwt:generate-keypair
```


4. start project
```shell
symfony server:start -d
```


5. Postman
```text
To test the various endpoints, you need to import the "postman_collection.json" file. 
Start by executing the "REQUIRED LOGIN" request to update the authentication key.

If you want to use a regular user, simply change {{admin_email}} in the list of variables.

Here is a list of available users:

Admin: admin@admin.com
Users: user_1@user.com, user_2@user.com, ... user_10@user.com.
Password: password
```


6. PHP UNIT
```shell
php bin/phpunit
```



BONUS PHP CS
```shell
composer phpcsfixer
```

