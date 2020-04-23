<?php
/**
 * Created by PhpStorm.
 * User: Kem Bi
 * Date: 06-Jul-18
 * Time: 4:00 PM
 */
$config = [
    'defaultRoute' => 'temp/index',
    'components' => [
        'errorHandler' => [
            'class' => \modava\temp\components\MyErrorHandler::class,
        ]
    ],
    'params' => require __DIR__ . '/params.php',
];

return $config;
