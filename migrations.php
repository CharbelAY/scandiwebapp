<?php

use app\core\Application;

require_once __DIR__ . "/vendor/autoload.php";

$config=[
    'db'=>[
        'dsn'=>"mysql:host=172.28.0.2;port=3306;dbname=admin;",
        'user'=>"root",
        'password'=>"root"
    ]
];


$app = new Application(dirname(__DIR__),$config);

$app->db->applyMigration();