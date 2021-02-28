<?php

use app\controllers\ProductController;
use app\core\Application;

require_once __DIR__ . "/../vendor/autoload.php";

$config=[
    'db'=>[
        'dsn'=>"mysql:host=172.28.0.2;port=3306;dbname=admin;",
        'user'=>"root",
        'password'=>"root"
    ]
];



$app = new Application(__DIR__,$config);


$app->router->get("/",function (){
    header('Location: '."/products/list");
    exit();
});

$app->router->get("/products/list",[ProductController::class,"productsList"]);

$app->router->post("/products/list",[ProductController::class,"massDelete"]);

$app->router->get("/error",function (){
    return "error";
});

$app->router->get("/addproduct",[ProductController::class,"addProduct"]);

$app->router->post("/addproduct",[ProductController::class,"handleAddProduct"]);


$app->run();