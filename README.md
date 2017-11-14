# PHP Library API
Utility classes for API

## Background ##

## Installation ##

Add the following to your composer file:

```json
   "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/sinevia/php-library-api.git"
        }
    ],
    "require": {
        "sinevia/php-library-api": "dev-master"
    },
```

## Usage ##

The lines bellow create an API service, which serves commands mapped to middleware and class methods:

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

class PingController{
    function ping(){
        return (new Sinevia\ApiResponse)->success('pong');
    }
}
```
