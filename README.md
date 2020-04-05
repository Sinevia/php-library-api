# PHP Library API

![Tests](https://github.com/Sinevia/php-library-html/workflows/Test/badge.svg)
[![Gitpod Ready-to-Code](https://img.shields.io/badge/Gitpod-Ready--to--Code-blue?logo=gitpod)](https://gitpod.io/#https://github.com/Sinevia/php-library-api) 

A package to quickly set a PHP webservice

## Background ##

## Installation ##

- Install via Composer
```php
composer require sinevia/php-library-api
```

## Usage ##

1. The lines bellow create an API service, which serves commands mapped to middleware and class methods:

```php
$commands = [
    'ping' => 'PingController@ping',
    
    'auth/login' => 'AuthController@login',
    'auth/register' => 'AuthController@register',
    'auth/password-restore' => 'AuthController@passwordRestore',
    
    'account/password-change' => ['MiddlewareController@verifyUser','AccountController@passwordChange'],
    
];

$api = new Sinevia\ApiService;
$api->addCommands($commands);
die($api->run());
```

2. Example controller with response:

```php
class PingController{
    function ping(){
        return (new Sinevia\ApiResponse)->success('pong');
    }
}
```
