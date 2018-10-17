<?php
$servername = "localhost";
$ad_username = "root";
$ad_password = "test";
$dbname = "db_cking";
$tablename = "users";
$username = "";
$email = "";
$errors = array();


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['register'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];

        //errorcheck
        if (empty($username)){
            array_push($errors, "Username is required");
        }
        if (empty($email)){
            array_push($errors, "Email is required");
        }
        if (empty($password_1)){
            array_push($errors, "Password is required");
        }
        if ($password_1 != $password_2){
            array_push($errors, "Passwords do not match");
        }

        //if no errors save user
        if(count($errors) == 0){
            $password = hash('whirlpool', str_rot13(password_1));
            $sql = "INSERT INTO db_cking.users (username, email, `password`) 
                VALUES ('$username','$email', '$password')";
            echo $sql;
            $conn->exec($sql);
        }

    }
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>