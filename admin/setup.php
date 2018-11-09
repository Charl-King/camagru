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
        echo "Database created successfully<BR/>";
    } else {
        echo "Error creating database: " . $conn->error."<BR/>";
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
        token VARCHAR(255) DEFAULT NULL,
        password VARCHAR(255),
        reg_date TIMESTAMP
        )";
    
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Table users created successfully<BR/>";

        $sql2 = "CREATE TABLE pictures (
            pic_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(255) NOT NULL,
            pic LONGTEXT NOT NULL,
            likes INT(100) UNSIGNED NOT NULL DEFAULT 0,
            sub_datetime TIMESTAMP
            )";
        $conn->exec($sql2);
        echo "Table pictures created successfully<BR/>";
        
        $sql3 = "CREATE TABLE comments (
            pic_id INT(11) UNSIGNED NOT NULL,
            username VARCHAR(255) NOT NULL,
            comment VARCHAR(500) NOT NULL,
            sub_datetime TIMESTAMP
            )";
        $conn->exec($sql3);
        echo "Table comments created successfully<BR/>";

        }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }
?>