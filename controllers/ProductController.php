<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Request;
use app\models\Product;

class ProductController extends BaseController
{

    public function productsList(){
        $this->setLayout("emptyLayout");
        $product = new Product();
        $fetchedData = $product->getAll();
        $params=[
            "names"=>$fetchedData,
        ];
        return  $this->render("productsList",$params);
    }

    public function massDelete(Request $request){
        $body = $request->getBody();
        if($body){
            $product = new Product();
            $product->delete(array_keys($body));
            header('Location: '."/products/list");
            exit();
        }else{
            $this->setLayout("emptyLayout");
            $params["names"]=[];
            return  $this->render("productsList",$params);
        }

    }

    public function addProduct(){
        $product = new Product();
        $this->setLayout("emptyLayout");
        return  $this->render("addProduct",["model"=>$product]);

    }

    public function handleAddProduct(Request $request){
        $product = new Product();
        $body = $request->getBody();
        $product->loadModel($body);
        if($product->save()){
            header('Location: '."/products/list");
            exit();
        }else{
            $this->setLayout("emptyLayout");
            return $this->render("addProduct",["model"=>$product]);
        }
    }

    function url(){
        return sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
        );
    }

}