<?php


namespace app\models;

use app\core\DbModel;
use http\Exception;

class Product extends DbModel
{
    public string $sku = "";
    public string $name = "";
    public float $price = 0;
    public string $type = "";
    public ?float $size = null;
    public ?int $product_type_id = null;
    public ?float $weight = null;
    public ?float $length = null;
    public ?float $width = null;
    public ?float $height = null;

    public static function present($fetchedData)
    {
        foreach ($fetchedData as &$element) {
            if ($element['type_name'] === 'DVD-disc') {
                $element['measurement_presentation'] = 'Size' . ": " . $element['size'] . $element['unit_of_measure'];
            } elseif ($element['type_name'] === 'Book') {
                $element['measurement_presentation'] = 'Weight' . ": " . $element['weight'] . $element['unit_of_measure'];;
            } else {
                $element['measurement_presentation'] = 'Dimentions' . ": " . $element['height'] . 'x' . $element['width'] . 'x' . $element['length'] . $element['unit_of_measure'];;
            }
        }
        return $fetchedData;
    }

    /**
     * @param $data
     * @throws \Exception
     */
    public function loadModel($data)
    {
        parent::loadModel($data);
        $this->validateSku($data['sku']);
//        $this->validateNumericData();
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


    public function dontSave(): array
    {
        return ['type'];
    }

    public function attributes(): array
    {
        return ["sku", "name", "price", "type", "size", "weight", "length", "width", "height", "product_type_id"];
    }
}