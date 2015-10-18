ZF OAuth2 Client Test
=====================

Introduction
------------
This is a simple server to test api-skeletons/zf-oauth2-client

Installation
------------

```sh
php composer.phar install
cp config/autoload/local.php.dist config/autoload/local.php
```

Edit `config/autoload/local.php` with the oauth2 server callback for user info.

Edit `config/autoload/zf-oauth2-client.global.php` for your OAuth2 server.

Run
---

```sh
php -S localhost:8082 -t public public/index.php
```
