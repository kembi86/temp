Login Backend
=============
Phiên bản login dành cho modava

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist "modava/auth @dev"
```

or add

```
"modava/auth": "dev"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

in file common/config/main.php add:
```php
'modules' => [
    'auth' => [
        'class' => 'modava\auth\Auth',
    ]
]
```

Run
-----

```php
http://localhost/project/auth
```