<?php


namespace app\models\products;


interface IProduct
{
    public function present();

    public function getOptionalFields();
}