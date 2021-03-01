<?php


namespace app\models;


use app\core\DbModel;

class ProductType extends DbModel
{

    public function tableName(): string
    {
        return 'product_type';
    }

    public function attributes(): array
    {
        return ['type_name','unit_of_measure'];
    }

    public function dontSave(): array
    {
        return [];
    }
}