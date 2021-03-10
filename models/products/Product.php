<?php


namespace app\models\products;

use app\core\DbModel;

class Product extends DbModel
{
    public int $id ;
    public string $sku = "";
    public string $name = "";
    public float $price = 0;
    public string $type = "";
    public ?string $measurement_presentation='';
    public ?string $unit_of_measure='';

    /**
     * @param $data
     * @throws \Exception
     */
    public function loadModel($data)
    {
        parent::loadModel($data);
        if($data['id']==='' || $data['id']===null){
            $this->validateSku($data['sku']);
        };
    }

    /**
     * @param $sku
     * @throws \Exception
     */
    private function validateSku($sku)
    {
        if ($this->getIdOfProperty($this->tableName(), 'sku', $sku) !== null) {
            throw new \Exception('SKU should be a unique value. The value you entered is already present in the database');
        }
    }

    public function tableName(): string
    {
        return 'product';
    }

    public function attributes(): array
    {
        return ["id","sku", "name", "price", "type", "size", "weight", "length", "width", "height", "product_type_id"];
    }

    public function dontSave(): array
    {
        return ['type',"id"];
    }
}