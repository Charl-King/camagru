<?php
    $servername = "localhost";
    $username = "root";
    $dbname = "db_cking";

    function prompt($prompt_msg){
        echo("<script type='text/javascript'> var answer = prompt('".$prompt_msg."'); </script>");

        $answer = "<script type='text/javascript'> document.write(answer); </script>";
        return($answer);
    }
    $prompt_msg = "Please enter database password:";
    $password = prompt($prompt_msg);

    // Create connection
    $conn = new mysqli($servername, $username, "test");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    // Create database
    $sql = "CREATE DATABASE $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, "test");
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // sql to create table
        $sql = "CREATE TABLE users (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        verified tinyint(1) NOT NULL DEFAULT '0',
        token varchar(255) DEFAULT NULL,
        password VARCHAR(255),
        reg_date TIMESTAMP
        )";
    
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Table users created successfully";

        $sql2 = "CREATE TABLE pictures (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(255) NOT NULL,
            pic LONGTEXT NOT NULL,
            sub_datetime TIMESTAMP
            )";
        $conn->exec($sql2);
        echo "Table pictures created successfully";
        
        }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }
//    $conn->close();
?>