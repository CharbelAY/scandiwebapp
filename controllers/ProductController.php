<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Request;
use app\models\OptionalsInputs;
use app\models\products\Product;
use app\models\products\Dvd;
use app\models\products\Book;
use app\models\ProductType;

class ProductController extends BaseController
{

    public function productsList()
    {
        $product = new Product();
        $fetchedData = $product->getAllWith('product_type');
        $products=[];
        foreach ($fetchedData as $data ){
            $name = "app\models\products\\" . $data["type_name"];
            $tempClass = new $name();

            $tempClass->loadModel($data);
            $tempClass->present();
            array_push($products,$tempClass);
        }
        $params = [
            "products" => $products,
        ];
        return $this->render("productsList", $params);
    }

    public function massDelete(Request $request)
    {
        $body = $request->getBody();
        if ($body) {
            $product = new Product();
            $product->delete(array_keys($body));
        }
        header('Location: ' . "/products/list");
        exit();
    }

    public function addProduct()
    {
        $product = new Product();
        $productType = new ProductType();
        return $this->render("addProduct", ["model" => $product, "optionalInputs" => [], "product_type" => $productType->getAll()]);

    }

    public function handleAddProduct(Request $request)
    {
        $productType = new ProductType();
        $optionalInputsClass = new OptionalsInputs();
        $body = $request->getBody();
        try {
            $name = "app\models\products\\" . $body['type'];
            $product = new $name();
            $product->loadModel($body);
        } catch (\Exception $e) {
            $productType = new ProductType();
            $productTypeId=$productType->getFirst("type_name",$product->type)['id'];
            $optionalInputsData = $optionalInputsClass->getAllWhere("product_type_id", $productTypeId);
            return $this->render("addProduct", ["model" => $product, "errorMessage" => $e->getMessage(), "optionalInputs" => $optionalInputsData, "product_type" => $productType->getAll()]);
        }
        $product->product_type_id = $product->getIdOfProperty('product_type', 'id', $body["product_type_id"]);

        try{
            $productType = new ProductType();
            $product->product_type_id=$productType->getFirst("type_name",$product->type)['id'];
            $product->save();
            header('Location: ' . "/products/list");
            exit();
        }catch (\Exception $e){
            $optionalInputsData = $optionalInputsClass->getAllWhere("product_type_id", $body["product_type_id"]);
            return $this->render("addProduct", ["model" => $product, "errorMessage" => $e->getMessage(), "optionalInputs" => $optionalInputsData, "product_type" => $productType->getAll()]);
        }
    }

    public function appendFormsDynamicField(Request $request)
    {
        header("Content-type:application/json");
        $optionalInputsClass = new OptionalsInputs();
        $body = $request->getBody();
        $productType =  new ProductType();
        $optionalInputs = [];
        if ($body['type'] !== null && $body['type'] !== '') {
            $name = "app\models\products\\" . $body['type'];
            $tempClass = new $name();
            $optionalInputs = $tempClass->getOptionalFields();
        }
        return json_encode($optionalInputs);
    }

}