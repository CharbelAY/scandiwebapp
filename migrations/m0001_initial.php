<?php


class m0001_initial{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQL = "
        CREATE TABLE product(
        id INT AUTO_INCREMENT PRIMARY KEY,
        sku VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        price INT NOT NULL,
        type VARCHAR(512) NOT NULL,
        measurementvalue VARCHAR(512) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=INNODB;
        ";
        $db->pdo->exec($SQL);
    }

    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE users ;";
        $db->pdo->exec($SQL);
    }
}