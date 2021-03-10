<?php


class m0001_initial
{

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



        foreach ($this->product_type_seeds as $product_type) {
            $this->seed("product_type", array_keys($product_type), $product_type);
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
        $db->pdo->exec($SQLProduct);
        $db->pdo->exec($SQLProductType);

    }
}