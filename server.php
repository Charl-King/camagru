<?php
session_start();

$servername = "localhost";
$ad_username = "root";
$ad_password = "test";
$tablename = "db_cking.users";
$tablename = "users";
$username = "";
$email = "";
$errors = array();

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['register'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];

        //errorcheck form
        if (empty($username)){array_push($errors, "Username is required");}
        if (empty($email)){array_push($errors, "Email is required");}
        if (empty($username)){array_push($errors, "Username is required");}
        if (empty($password_1)){array_push($errors, "Password is required");}
        if ($password_1 != $password_2){array_push($errors, "Passwords do not match");}

        //check if user doesn't already exist or email

        $stmt = $conn->prepare("SELECT * FROM db_cking.users WHERE username = :usr OR email = :eml");
        $stmt->execute(["usr"=>$username, "eml"=>$email]);
        $results = $stmt->fetchAll();

        if (sizeof($results) >= 1){array_push($errors, "Username/Email already in use");}
        // $stmt = $conn->prepare("SELECT * FROM users WHERE username = :usrnme AND `password` = :pswrd"); 
        // $stmt->execute([`usrnme`=>$username, `pswrd`=>$password]);
        // $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        // $results = $stmt->FetchAll();
        // if (sizeof($results) != 0){array_push($errors, "Username/email already in use");}

        ///////////////////////////////

        //if no errors save user
        if(count($errors) == 0){
            $password = hash('whirlpool', str_rot13($password_1));
            console.log($password) ;
            $sql = "INSERT INTO db_cking.users (username, email, `password`) 
                VALUES ('$username','$email', '$password')";
            $conn->exec($sql);
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are logged in";
            header('location: index.php');
        }

    }
}
catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}

if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['username']);
    header('location:index.php');
}

if (isset($_POST['login'])){

    $username = ($_POST['username']);
    $password = ($_POST['password']);

    if (empty($username)){
        array_push($errors, "Username is required");
    }

    if (empty($password)){
        array_push($errors, "Password is required");
    }

    if(count($errors) == 0){
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password, $opt);
        $password = hash('whirlpool', str_rot13($password));


        $stmt = $conn->prepare("SELECT * FROM db_cking.users WHERE username = :usr AND password = :psw");
        $stmt->execute(["usr"=>$username, "psw"=>$password]);
        $results = $stmt->fetchAll();

        if (sizeof($results) == 1){
             $_SESSION['username'] = $username;
             $_SESSION['success'] = "You are logged in";
            header('location: index.php');
             }
         else{
             array_push($errors, "The username/password provided is invalid");
             header('location: login.php');
         }
    }
}

?>