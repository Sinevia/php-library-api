# PHP Library API

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
