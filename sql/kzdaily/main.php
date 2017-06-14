<?php
return [
    'add' => [
        'sql' => 'INSERT INTO `kz_daily`(`date`,`price`)'.
            ' SELECT :date, AVG(`price`) FROM kz_trader_log',
        'defaultWhere' => false,
        'where' => [
            ':addtimeGte' => [
                'sql'  => 'addtime >= :addtimeGte',
                'link' => 'AND'
            ],
            ':addtimeLte' => [
                'sql'  => 'addtime <= :addtimeLte',
                'link' => 'AND'
            ]
        ],
        'pdoParam' =>[':date', ':addtimeGte', ':addtimeLte']
    ],
];
