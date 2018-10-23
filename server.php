<?php
session_start();

$servername = "localhost";
$ad_username = "root";
$ad_password = "test";
$tablename = "db_cking.users";
$dbname = "db_cking";
$username = "";
$email = "";
$errors = array();

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password, $opt);

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

        //if no errors save user
        if(count($errors) == 0){
            $password = hash('whirlpool', str_rot13($password_1));
            $token = hash('whirlpool',$username);  //set verification token
            $ver_link = "http://localhost:8080/camagru/verify.php?token=".$token; //construct verification link
            $sql = "INSERT INTO db_cking.users (username, email, `password`, token) 
                VALUES ('$username','$email', '$password', '$token')";
            $conn->exec($sql);
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are logged in";
        
        //send verification email
            
            $msg = "Please follow the link below\nto verify your account\n$ver_link";
            $msg = wordwrap($msg,70);
            mail("$email","Verification email",$msg);

            header('location: login.php');
        }

    }
}
catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}
//logout
if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['username']);
    header('location:login.php');
}

//login
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
            //check if verified
            $stmt = $conn->prepare("SELECT * FROM db_cking.users WHERE username = :usr AND verified = 1");
            $stmt->execute(["usr"=>$username]);
            $results = $stmt->fetchAll();
            if(sizeof($results) == 1){
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are logged in";
                header('location: index.php');}
            else{
               array_push($errors, "Please verify email address via link sent to your email before logging in");
            }
        }
         else{
            array_push($errors, "The username/password provided is invalid");
         }
    }
}

//verification when link is clicked on
if (isset($_GET['token'])){
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password, $opt);
    $token = $_GET['token'];
    $stmt = $conn->prepare("UPDATE db_cking.users SET verified = 1 WHERE token = :tkn");
    $stmt->execute(["tkn"=>$token]);
}

//Password recovery
if (isset($_POST['pwrst'])){
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password, $opt);
    $stmt = $conn->prepare("SELECT token FROM db_cking.users WHERE email = :email");
    $stmt->execute(["email"=>$_POST['email']]);
    $results = $stmt->fetchAll();
    $token = $results[0]['token'];
    $ver_link = "http://localhost:8080/camagru/password_reset.php?token=".$token; //contruct reset link

    //send reset email          
    $msg = "Please follow the link below,\nto reset your account:\n$ver_link";
    $msg = wordwrap($msg,70);
    $email = $_POST['email'];
    mail("$email","Verification email",$msg);
}

//reset password when link is clicked
if (isset($_POST['changepw'])){
    $token = $_SESSION['token'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];
    if (empty($password_1)){array_push($errors, "Password is required");}
    if ($password_1 != $password_2){array_push($errors, "Passwords do not match");}
    if(count($errors) == 0){
        $password = hash('whirlpool',str_rot13($password_1));
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password, $opt);
        $stmt = $conn->prepare("UPDATE db_cking.users SET password = :psw WHERE token = :tkn");
        $stmt->execute(["tkn"=>$token,"psw"=>$password]);
    }
    unset($_SESSION['token']);
}
?>