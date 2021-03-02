<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Request;
use app\models\OptionalsInputs;
use app\models\Product;
use app\models\ProductType;
use mysql_xdevapi\Exception;

class ProductController extends BaseController
{

    public function productsList()
    {
        $product = new Product();
        $fetchedData = $product->getAllWith('product_type');
        $fetchedData = Product::present($fetchedData);
        $params = [
            "products" => $fetchedData,
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
        $product = new Product();
        $productType = new ProductType();
        $optionalInputsClass = new OptionalsInputs();
        $body = $request->getBody();
        try {
            $product->loadModel($body);
        } catch (\Exception $e) {
            $optionalInputsData = $optionalInputsClass->getAllWhere("product_type_id", $body["product_type_id"]);
            return $this->render("addProduct", ["model" => $product, "errorMessage" => $e->getMessage(), "optionalInputs" => $optionalInputsData, "product_type" => $productType->getAll()]);
        }
        $product->product_type_id = $product->getIdOfProperty('product_type', 'id', $body["product_type_id"]);

        try{
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
        $optionalInputs = [];
        if ($body['type'] !== null && $body['type'] !== '') {
            $optionalInputs = $optionalInputsClass->getAllWhere("product_type_id", $body["type"]);
        }
        return json_encode($optionalInputs);
    }

}