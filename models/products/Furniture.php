<?php


namespace app\models\products;


class Furniture extends Product implements IProduct
{

    public ?float $length = null;
    public ?float $width = null;
    public ?float $height = null;

    public function present()
    {
        $this->measurement_presentation = 'Dimentions' . ": " . $this->length. "x" . $this->width . "x" . $this->height . $this->unit_of_measure;

    }

    public function getOptionalFields()
    {
        return [[
            "label"=>"Height (CM)",
            "name"=> "height",
            "message"=> "This is the height in centimeters",
            "type"=> "number",
            "step"=> "0.001",
            ],
            [
                "label"=>"Length (CM)",
                "name"=> "length",
                "message"=> "This is the length in centimeters",
                "type"=> "number",
                "step"=> "0.001",
            ],
            [
                "label"=>"Width (CM)",
                "name"=> "width",
                "message"=> "This is the length in centimeters",
                "type"=> "number",
                "step"=> "0.001",
            ]
        ];
    }
}