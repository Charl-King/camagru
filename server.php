<?php
$servername = "localhost";
$username = "root";
$password = "test";
$dbname = "db_cking";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['register'])){
        $username = mysql_real_escape_string($_POST['username']);
        $email = mysql_real_escape_string($_POST['email']);
        $password_1 = mysql_real_escape_string($_POST['password_1']);
        $password_2 = mysql_real_escape_string($_POST['password_2']);

    }
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>