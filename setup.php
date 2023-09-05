<?php
    include("pdo.php");

    // Run this once to create the table necessary

    try {
        $sql = "CREATE TABLE IF NOT EXISTS autos (
            auto_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            make VARCHAR(128),
            year INTEGER,
            mileage INTEGER,
            seat_cap INTEGER,
            car_type VARCHAR(128),
            
            PRIMARY KEY (auto_id)
        ) ENGINE=InnoDB CHARSET=utf8";
    
        $pdo->exec($sql);

        $sql3 = "INSERT INTO users (name, email, password) VALUES ('rohan', 'rohanhoval007@gmail.com', 'rohan123')";

        $pdo->exec($sql3);

        echo "<h2>Table created successfully</h2>";
    } catch (PDOException $e) {
        echo "<h2>Error has occured check if database and users have been set up properly </h2>";
        echo "<br />".$e->getMessage()."<br />";
    }
?>