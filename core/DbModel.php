<?php


namespace app\core;


abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array ;

    abstract public function dontSave(): array ;


    public function save(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $dontSave = $this->dontSave();
        $attributes = array_diff($attributes,$dontSave);
        $params = array_map(fn($attr)=>":$attr",$attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',',$attributes).") VALUES (".implode(",",$params).")");
        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute",$this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function getAll(){
        $tableName = $this->tableName();
        $statement = self::prepare("SELECT * FROM $tableName");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllWith($table){
        $tableName = $this->tableName();
        $tableId = $table . "_id";
        $statement = self::prepare("SELECT a.* , b.* FROM $tableName as b ,$table as a WHERE a.id = b.$tableId ");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllWhere($key,$value){
        $tableName = $this->tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE $key= '$value' ");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getIdOfProperty($table,$columnName,$value){
        $statement = self::prepare("SELECT id FROM $table WHERE $columnName= '$value' ");
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC)['id'];
    }

    public function delete($ids){
        $tableName = $this->tableName();
        $params = str_repeat('?,', count($ids) - 1) . '?';
        $statement = self::prepare("DELETE FROM $tableName WHERE id IN ($params)");
        $statement->execute($ids);
    }

    public static function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }
}