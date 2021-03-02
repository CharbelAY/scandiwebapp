<?php


class m0001_initial
{

    private $optional_inputs_seeds = [
        ["label" => "Size (MB)", "name" => "size", "type" => "number", "message" => "This is the storage in megabytes", "step" => 0.001, "product_type_id" => 1],
        ["label" => "Weight (KG)", "name" => "weight", "type" => "number", "message" => "This is the weight in kilograms", "step" => 0.001, "product_type_id" => 2],
        ["label" => "Height (CM)", "name" => "height", "type" => "number", "message" => "This is the height in centimeters", "step" => 0.001, "product_type_id" => 3],
        ["label" => "Length (CM)", "name" => "length", "type" => "number", "message" => "This is the length in centimeters", "step" => 0.001, "product_type_id" => 3],
        ["label" => "Width (CM)", "name" => "width", "type" => "number", "message" => "This is the width in centimeters", "step" => 0.001, "product_type_id" => 3],
    ];


    private $product_type_seeds = [
        ["type_name" => "DVD-disc", "unit_of_measure" => "mb"],
        ["type_name" => "Book", "unit_of_measure" => "kg"],
        ["type_name" => "Furniture", "unit_of_measure" => "cm"],
    ];


    public function up()
    {
        $db = \app\core\Application::$app->db;


        $SQLProductType = "
        CREATE TABLE product_type(
        id INT AUTO_INCREMENT PRIMARY KEY,
        type_name VARCHAR(255) NOT NULL,
        unit_of_measure VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;
        ";

        $db->pdo->exec($SQLProductType);


        $SQLProduct = "
        CREATE TABLE product(
        id INT AUTO_INCREMENT PRIMARY KEY,
        sku VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        price FLOAT NOT NULL,
        product_type_id INT NOT NULL,
        size FLOAT ,
        weight FLOAT ,
        length FLOAT ,
        width FLOAT ,
        height FLOAT ,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (product_type_id) REFERENCES product_type (id)
        ) ENGINE=INNODB;
        ";


        $db->pdo->exec($SQLProduct);

        $SQLOptionalInputs = "
        CREATE TABLE optional_inputs(
        id INT AUTO_INCREMENT PRIMARY KEY,
        label VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        message VARCHAR(255) NOT NULL,
        type VARCHAR(255) NOT NULL,
        step float,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        product_type_id INT NOT NULL,
        FOREIGN KEY (product_type_id) REFERENCES product_type (id)
        ) ENGINE=INNODB;
        ";
        $db->pdo->exec($SQLOptionalInputs);


        foreach ($this->product_type_seeds as $product_type) {
            $this->seed("product_type", array_keys($product_type), $product_type);
        }

        foreach ($this->optional_inputs_seeds as $optionals_inputs) {
            $this->seed("optional_inputs", array_keys($optionals_inputs), $optionals_inputs);
        }

    }


    public function seed($tableName, $attributes, $seeds)
    {
        $db = \app\core\Application::$app->db;
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = $db->pdo->prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $seeds[$attribute]);
        }
        $statement->execute();
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $SQLProduct = "DROP TABLE product ;";
        $SQLProductType = "DROP TABLE product_type ;";
        $SQLOptionalInputs = "DROP TABLE optional_inputs ;";
        $db->pdo->exec($SQLProduct);
        $db->pdo->exec($SQLProductType);
        $db->pdo->exec($SQLOptionalInputs);

    }
}