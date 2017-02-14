<?php
if(YII_ENV != 'prod'){
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=guestbook',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
    ];
}else{
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=120.24.164.127;dbname=ancdone',
        'username' => 'luolei',
        'password' => 'LL19891106aa',
        'charset' => 'utf8',
    ];
}