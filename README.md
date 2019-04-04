## Laravel Smartdetect
___Cool development helper for Laravel.___

_Tested on Laravel 5.8_

### Install

Require this package with composer using the following command:
```bash
composer require lotfixyz/laravel-smartdetect
```

After composer command done, add autoload to `autoload/psr-4` of your the `composer.json` file.
```php
"Lotfixyz\\Smartdetect\\": "vendor/lotfixyz/laravel-smartdetect/src"
```

Something like this:
```comment
...
"autoload": {
    "psr-4": {
        ...
        "Lotfixyz\\Smartdetect\\": "vendor/lotfixyz/laravel-smartdetect/src"
    },
    ...
},
...
```

### Install --dev

To install this package on only development systems, add the `--dev` flag to your composer command:
```bash
composer require --dev lotfixyz/laravel-smartdetect
```

After composer command done, add autoload to `autoload-dev/psr-4` of your the `composer.json` file.
```php
"Lotfixyz\\Smartdetect\\": "vendor/lotfixyz/laravel-smartdetect/src"
```

Something like this:
```comment
...
"autoload-dev": {
    "psr-4": {
        ...
        "Lotfixyz\\Smartdetect\\": "vendor/lotfixyz/laravel-smartdetect/src"
    },
    ...
},
...
```

### Important Note:

Don't forget to run `composer dump-autoload` after any change of your `composer.json` file.

### Publishing

You can publish the config file to take the control of your defaults and settings.

Run `php artisan vendor:publish` and select `Lotfixyz\Smartdetect\SmartdetectServiceProvider`

### Environment File

You can also optionally add following lines to your .env file.
```dotenv
SMARTDETECT_TURNED_OFF=false
SMARTDETECT_DEBUG_MODE="${APP_DEBUG}"
SMARTDETECT_INVOLVE_CONFIG=true
SMARTDETECT_INVOLVE_DOMAIN=true
SMARTDETECT_INVOLVE_IP=true
SMARTDETECT_INVOLVE_REQUEST=true
SMARTDETECT_INVOLVE_USER=true
```

### Usage

Simply use this sample.
```php
$smartdetect = new SmartdetectClass();
$smartdetect->bind_ip('94.232.175.55');
$smartdetect->bind_domain('lotfi.xyz', SmartdetectClass::DOMAIN_TYPE_ENTIRE);
$smartdetect->bind_domain('.xyz', SmartdetectClass::DOMAIN_TYPE_EXTENSION);
$smartdetect->bind_domain('lotfi.', SmartdetectClass::DOMAIN_TYPE_NAME);
$smartdetect->bind_request('with_value', 110);
$smartdetect->bind_request('without_value');
$smartdetect->bind_user('demo', SmartdetectClass::USER_TYPE_EMAIL);
$smartdetect->bind_user('2', SmartdetectClass::USER_TYPE_ID);
$smartdetect->make();
dd((array)$smartdetect->result);
```
### Note

Documents and New Features are upcoming... 

### License

The Laravel Smartdetect is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
