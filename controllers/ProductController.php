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
        $fetchedProducts = $product->getAllWith('product_type');
        $products=[];
        foreach ($fetchedProducts as $data ){
            $className = "app\models\products\\" . $data["type_name"];
            $object = new $className();
            $object->loadModel($data);
            $object->present();
            array_push($products,$object);
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
        $body = $request->getBody();
        try {
            $className = "app\models\products\\" . $body['type'];
            $product = new $className();
            $product->loadModel($body);
            $product->product_type_id = $productType->getFirst("type_name",$product->type)['id'];
            $product->save();
            header('Location: ' . "/products/list");
            exit();
        } catch (\Exception $e) {
            return $this->render("addProduct", ["model" => $product, "errorMessage" => $e->getMessage(), "optionalInputs" => $product->getOptionalFields(), "product_type" => $productType->getAll()]);
        }
    }

    public function appendFormsDynamicField(Request $request)
    {
        header("Content-type:application/json");
        $body = $request->getBody();
        $optionalInputs = [];
        if ($body['type'] !== null && $body['type'] !== '') {
            $className = "app\models\products\\" . $body['type'];
            $object = new $className();
            $optionalInputs = $object->getOptionalFields();
        }
        return json_encode($optionalInputs);
    }

}