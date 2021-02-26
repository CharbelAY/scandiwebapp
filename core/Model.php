<?php


namespace app\core;


abstract class Model
{

    public const RULE_REQUIRED = "required";

    public function loadModel($data){
        foreach ($data as $key=>$value){
            if (property_exists($this,$key)){
                $modelKey=$this->{$key};
                $keyType = gettype($modelKey);
                if($keyType==="integer"){
                    $this->{$key}= (int)$value;
                }else{
                    $this->{$key}=$value;

                }
            }
        }
    }

}