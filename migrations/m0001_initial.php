<?php


class m0001_initial{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQLProduct = "
        CREATE TABLE product(
        id INT AUTO_INCREMENT PRIMARY KEY,
        sku VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        price INT NOT NULL,
        product_type_id INT NOT NULL,
        size INT,
        weight INT,
        length INT,
        width INT,
        height INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;
        ";


        $db->pdo->exec($SQLProduct);

        $SQLProductType = "
        CREATE TABLE product_type(
        id INT AUTO_INCREMENT PRIMARY KEY,
        type_name VARCHAR(255) NOT NULL,
        unit_of_measure VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;
        ";

        $db->pdo->exec($SQLProductType);
    }

    public function down(){
        $db = \app\core\Application::$app->db;
        $SQLProduct = "DROP TABLE product ;";
        $SQLProductType = "DROP TABLE product_type ;";
        $db->pdo->exec($SQLProduct);
        $db->pdo->exec($SQLProductType);

    }
}