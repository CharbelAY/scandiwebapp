<?php


namespace app\models\products;


class Book extends Product implements IProduct
{
    public ?float $weight = null;


    public function present()
    {
        $this->measurement_presentation = 'Weight' . ": " . $this->weight . $this->unit_of_measure;
    }

    public function getOptionalFields()
    {
        return [[
            "label"=>"Weight (KG)",
            "name"=> "weight",
            "message"=> "This is the weight in kilograms",
            "type"=> "number",
            "step"=> "0.001",
        ]
        ];
    }
}