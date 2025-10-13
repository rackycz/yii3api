<?php

declare(strict_types=1);

use Yiisoft\Db\Mysql\Dsn;

return [
    'application' => require __DIR__ . '/application.php',

    'yiisoft/aliases' => [
        'aliases' => require __DIR__ . '/aliases.php',
    ],

    'yiisoft/db-mysql' => [
        'dsn' => (new Dsn('mysql', getenv('DB_HOST'), getenv('DB_DATABASE'), '3306', ['charset' => 'utf8mb4']))->asString(),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
    ],
];
