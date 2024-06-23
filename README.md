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


4. start project
```shell
symfony server:start -d
```

BONUS PHP CS
```shell
composer phpcsfixer
```