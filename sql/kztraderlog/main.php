<?php
return [
    'add' => 'INSERT INTO `kz_trader_log`(`addtime` , `type`,`price`,`num`,`mum`,`md5`)'.
        'VALUES (:addtime, :type,:price,:num,:mum,:md5);',
    'getAll' => [
        'sql' => 'SELECT * FROM `kz_trader_log`',
        'defaultWhere' => false,
        'where' => [
            ':md5' => [
                'sql'  =>'`md5`=:md5',
                'link' => 'AND'
            ],
            ':addtimeGte' => [
                'sql'  => 'addtime >= :addtimeGte',
                'link' => 'AND'
            ],
            ':addtimeLte' => [
                'sql'  => 'addtime <= :addtimeLte',
                'link' => 'AND'
            ]
        ],
        'pdoParam' => [':md5', ':addtimeGte', ':addtimeLte']
    ],
];
