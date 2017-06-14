<?php

return [
    'httpRoot' => 'http://kz.com',
    'rootPath' => '/www/kuzhuan',
    'routeParam' => 'R',
    'allowGuest' => [
        'login'    => ['index', 'login' ],
        'register' => ['index', 'register']
    ],
    'systemUserId' => 17,
    'sessionPath' => '/www/kuzhuan/temp/session',
    'mysql' => [
        'host' => '192.168.1.16',
        'port' => 3306,
        'dbname' => 'kz',
        'user' => 'lohoerp',
        'password' => 'lohoerp',],
    'cli'=> [
        'user'    => 'system',
        'user_id' => 17
    ]

];