<?php


namespace app\models\products;


class Dvd extends Product implements IProduct
{

    public ?float $size = null;


    public function present()
    {
        $this->measurement_presentation = 'Size' . ": " . $this->size . $this->unit_of_measure;

    }

    public function getOptionalFields()
    {
        return [[
            "label"=>"Size (MB)",
            "name"=> "size",
            "message"=> "This is the storage in megabytes",
            "type"=> "number",
            "step"=> "0.001",
            ]
        ];
    }
}