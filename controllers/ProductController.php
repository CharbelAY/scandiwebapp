<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Request;
use app\models\Product;
use mysql_xdevapi\Exception;

class ProductController extends BaseController
{

    public function productsList(){
        $product = new Product();
        $fetchedData = $product->getAllWith('product_type');
        $fetchedData = Product::present($fetchedData);
        $params=[
            "products"=>$fetchedData,
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
            header('Location: '."/products/list");
            exit();
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
        try {
            $product->loadModel($body);
        }catch (\Exception $e){
            return $this->render("addProduct",["model"=>$product,"errorMessage"=>$e->getMessage()]);
        }
        $product->product_type_id = $product->getIdOfProperty('product_type','type_name',$product->type);
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