<?php


namespace app\models;

use app\core\DbModel;

class Product extends DbModel
{
    public string $sku;
    public string $name;
    public float $price;
    public string $type;
    public ?float $size=null;
    public int $product_type_id ;
    public ?float $weight=null;
    public ?float $length=null;
    public ?float $width=null;
    public ?float $height=null;


    public function tableName(): string
    {
        return 'product';
    }

    public function loadModel($data)
    {
        parent::loadModel($data);
    }

    public function prepareModel($data){
        if(array_key_exists ( "type" ,  $data )){
            if($data["type"]==="size"){
                $this->type="DVD-disc";
            }
            if($data["type"]==="weight"){
                $this->type="Book";
            }
            if($data["type"]==="dimensions"){
                $this->type="Furniture";
            }
        }
    }

    public static function present($fetchedData){
        foreach ($fetchedData as &$element){
            if($element['type_name']==='DVD-disc'){
                $element['measurement_presentation'] = 'Size' . ": " . $element['size'] . $element['unit_of_measure'];
            }elseif ($element['type_name']==='Book'){
                $element['measurement_presentation']= 'Weight' . ": " . $element['weight'] . $element['unit_of_measure'];;
            }else{
                $element['measurement_presentation']= 'Dimentions' . ": " . $element['height'] . 'x' . $element['width'] . 'x' . $element['length'] . $element['unit_of_measure'];;
            }
        }
        return $fetchedData;
    }

    public function dontSave():array{
        return ['type'];
    }

    public function attributes(): array
    {
        return ["sku","name","price","type","size","weight","length","width","height","product_type_id"];
    }
}