<?php


namespace app\models;


use app\core\DbModel;

class OptionalsInputs extends DbModel
{

    public function tableName(): string
    {
        return "optional_inputs";
    }

    public function attributes(): array
    {
        return ["label","name","message","type","step","product_type_id"];
    }

    public function dontSave(): array
    {
        return [];
    }
}