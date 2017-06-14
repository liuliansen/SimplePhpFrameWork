<?php
return [
    'add' => 'INSERT INTO `user_kzcookie`(`user_id` , `cookie`)'.
             'VALUES (:userId, :cookie);',
    'delete' =>[
        'sql' => 'DELETE FROM `user_kzcookie`',
        'defaultWhere' => false,
        'where' => [
            ':userId' => [
                'sql'  =>'`user_id`=:userId',
                'link' => 'AND'
            ]
        ],
        'pdoParam' => [':userId']
    ],
    'getAll' => [
        'sql' => 'SELECT * FROM `user_kzcookie`',
        'defaultWhere' => false,
        'where' => [
            ':userId' => [
                'sql'  =>'`user_id`=:userId',
                'link' => 'AND'
            ]
        ],
        'pdoParam' => [':userId']
    ],
    'getUserCookie' => [
        'sql' => 'SELECT `cookie` FROM `user_kzcookie`',
        'defaultWhere' => false,
        'where' => [
            ':userId' => [
                'sql'  =>'`user_id`=:userId',
                'link' => 'AND'
            ]
        ],
        'pdoParam' => [':userId']
    ],
    'update' => 'UPDATE `user_kzcookie` SET `cookie` = :cookie WHERE `user_id` = :userId'
];