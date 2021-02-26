<?php

namespace app\core;


class Router
{
    public array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request,Response $response){
        $this->request = $request;
        $this->response=$response;
    }

    public function get($path,$callback){
        $this->routes["GET"][$path]=$callback;
    }

    public function post($path,$callback){
        $this->routes["POST"][$path]=$callback;
    }


    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback===false){
            $this->response->set_status_code(404);
            return $this->render_view("notfound");
        }

        if(is_array($callback)){
            Application::$app->setController(new $callback[0]());
            $callback[0]=Application::$app->getController();
        }

        return call_user_func($callback,$this->request);

    }

    public function render_view($view,$params=[]){
        $layout = $this->get_layout();
        $view = $this->get_view($view,$params);
        return str_replace("{{content}}",$view,$layout);
    }

    protected function get_layout(){
        $layout = Application::$app->getController()->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/../views/layouts/$layout.php";
        return ob_get_clean();
    }


    protected function get_view($view,$params){
        foreach ($params as $key=>$value){
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/../views/$view.php";
        return ob_get_clean();
    }

}