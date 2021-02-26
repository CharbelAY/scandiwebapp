<?php


namespace app\models;

use app\core\DbModel;

class Product extends DbModel
{
    public string $sku="";
    public string $name="";
    public int $price=0;
    public string $type="";
    public string $measurementvalue="";


    public function tableName(): string
    {
        return 'product';
    }

    public function loadModel($data)
    {
        parent::loadModel($data);
        if(array_key_exists ( "size" ,  $data )){
            $this->measurementvalue=$data["size"];
        }
        else if(array_key_exists ( "weight" ,  $data )){
            $this->measurementvalue=$data["weight"];
        }
        else if(array_key_exists ( "height" ,  $data )){
            $this->measurementvalue= $data["height"]."x".$data["width"]."x".$data["length"];
        }

    }


    public function attributes(): array
    {
        return ["sku","name","price","type","measurementvalue"];
    }
}