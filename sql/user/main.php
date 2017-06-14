<?php

return [
    'add' => 'INSERT INTO `user`( `user`, `password`, `email`, `phone`) VALUES (:user, :password, :email, :phone)',
    'getAll' => [
        'sql' => 'SELECT * FROM `user`',
        'defaultWhere' => false,
        'where' => [
            ':user' => [
                'sql'  =>'`user`=:user',
                'link' => 'AND'
            ],
            ':phone' => [
                'sql'  =>'`phone`=:phone',
                'link' => 'AND'
            ],
        ],
        'pdoParam' => [':user', ':phone']
    ],
    'getUserTraderPassword' => 'SELECT `trader_password` FROM `user` WHERE id = :userId'
];
