<?php

namespace app\core;



use app\controllers\ProductController;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public BaseController $controller;
    public static Application $app;
    public Database $db;

    public function __construct($rootPath,$config){
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request=new Request();
        $this->response = new Response();
        $this->db=new Database($config["db"]);
        $this->router=new Router($this->request,$this->response);
    }

    public function getController(): BaseController
    {
        return $this->controller;
    }

    public function setController(BaseController $controller): void
    {
        $this->controller = $controller;
    }



    public function run(){
        echo $this->router->resolve();
    }
}