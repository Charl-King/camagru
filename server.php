<?php
session_start();
$username = "";
$email = "";
$errors = array();

try {
    require('connect.php');
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
            $password = hash('whirlpool', str_rot13($password));
            $stmt = $conn->prepare("SELECT * FROM db_cking.users WHERE username = :usr AND password = :psw");
            $stmt->execute(["usr"=>$username, "psw"=>$password]);
            $results = $stmt->fetchAll();

            if (sizeof($results) == 1){
                //check if verified
                $stmt = $conn->prepare("SELECT * FROM db_cking.users WHERE username = :usr AND verified > 0");
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
        $token = $_GET['token'];
        $stmt = $conn->prepare("UPDATE db_cking.users SET verified = 1 WHERE token = :tkn");
        $stmt->execute(["tkn"=>$token]);
    }
    //Password recovery
    if (isset($_POST['pwrst'])){
        $stmt = $conn->prepare("SELECT token FROM db_cking.users WHERE email = :email");
        $stmt->execute(["email"=>$_POST['email']]);
        $results = $stmt->fetchAll();
        $token = $results[0]['token'];
        $ver_link = "http://localhost:8080/camagru/password_reset.php?token=".$token; //contruct reset link

        //send reset email          
        $msg = "Please follow the link below,\nto reset your account:\n$ver_link";
        $msg = wordwrap($msg,70);
        $email = $_POST['email'];
        mail("$email","Password reset link for Camagru",$msg);
        header("location:password_reset_notification.php");
    }
    //reset password when link is clicked
    if (isset($_POST['changepw'])){
        if(isset($_SESSION['token']))
            $token = $_SESSION['token'];
        else
            {array_push($errors, "Invalid token");}
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];
        if (empty($password_1)){array_push($errors, "Password is required");}
        if ($password_1 != $password_2){array_push($errors, "Passwords do not match");}
        if(count($errors) == 0){
            $password = hash('whirlpool',str_rot13($password_1));
            $stmt = $conn->prepare("UPDATE db_cking.users SET password = :psw WHERE token = :tkn");
            $stmt->execute(["tkn"=>$token,"psw"=>$password]);
        }
        unset($_SESSION['token']);
    }
    //receiving picture
    if(isset($_POST['submit_pic'])){
        $pic = $_POST['pic'];
        $username = $_POST['username'];
        $sql = "INSERT INTO db_cking.`pictures` (username, pic) VALUES ('$username','$pic')";
        $conn->exec($sql);
    }

    //adding comment
    if (isset($_POST['comment']) && isset($_SESSION['username'])){
        $comment = $_POST['comment'];
        $username = $_SESSION['username'];
        $pic_id = $_POST['pic_id'];
        $sql = "INSERT INTO db_cking.comments (pic_id, username, comment) 
                VALUES ('$pic_id','$username', '$comment')";
        $conn->exec($sql);
        $sql2="SELECT email FROM users INNER JOIN `pictures` ON users.username = pictures.username WHERE pic_id = $pic_id AND verified = 2;";
        $stmt = $conn->prepare($sql2);
        $stmt->execute();
        $results = $stmt->fetch();
        $email = ($results['email']);
        if ($results){
        $msg = "Someone commented on your picture. Follow this link: http://localhost:8080/camagru/image.php?pic_id=".$pic_id;
        mail($email,"Comment on your photo",$msg);}
        unset($_POST['comment']);
    }

    //adding a like
    if(isset($_POST['like_pic'])){
        $pic_id = $_POST['pic_id'];
        $sql = "UPDATE db_cking.pictures SET likes = likes + 1 WHERE pic_id = $pic_id";
        $conn->exec($sql);
    }
    //change pw
    if (isset($_POST['changepw1'])){
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];
        if (empty($password_1)){array_push($errors, "Password is required");}
        if ($password_1 != $password_2){array_push($errors, "Passwords do not match");}
        if(count($errors) == 0){
            $password = hash('whirlpool',str_rot13($password_1));
            $stmt = $conn->prepare("UPDATE db_cking.users SET password = :psw WHERE username = :usr");
            $stmt->execute(["usr"=>$_SESSION['username'],"psw"=>$password]);
            header('location: index.php');
        }
    }

    //change username
    if (isset($_POST['change_username'])){
        //validate new username
        $stmt = $conn->prepare("SELECT * FROM db_cking.users WHERE username = :usr OR email = :eml");
        $stmt->execute(["usr"=>$username, "eml"=>$email]);
        $results = $stmt->fetchAll();
        if (sizeof($results) >= 1){array_push($errors, "Username/Email already in use");}

        else{
        $new = $_POST['new_username'];
        $old = $_SESSION['username'];
        $stmt = $conn->prepare("UPDATE db_cking.users SET username = :new WHERE username = :old");
        $stmt->execute(["new"=>$new,"old"=>$old]);
        $_SESSION['username'] = $new;
        $stmt = $conn->prepare("UPDATE db_cking.pictures SET username = :new WHERE username = :old");
        $stmt->execute(["new"=>$new,"old"=>$old]);}
    }

    //change email
    if (isset($_POST['change_email'])){
        $new = $_POST['new_email'];
        //////////////////////////////
        $stmt = $conn->prepare("SELECT * FROM db_cking.users WHERE email = :eml");
        $stmt->execute(["eml"=>$new]);
        $results = $stmt->fetchAll();
        if (sizeof($results) >= 1){array_push($errors, "Username/Email already in use");}
        ///////////////////////////////
        else{
        $old = $_SESSION['username'];
        $stmt = $conn->prepare("UPDATE db_cking.users SET email = :new WHERE username = :old");
        $stmt->execute(["new"=>$new,"old"=>$old]);}
    }

    //change notification pref on
    if (isset($_POST['noti_on'])){
        $usr = $_SESSION['username'];
        $stmt = $conn->prepare("UPDATE db_cking.users SET verified = 2 WHERE username = :usr");
        $stmt->execute(["usr"=>$usr]);
    }
    //change notification pref off
    if (isset($_POST['noti_off'])){
        $usr = $_SESSION['username'];
        $stmt = $conn->prepare("UPDATE db_cking.users SET verified = 1 WHERE username = :usr");
        $stmt->execute(["usr"=>$usr]);
    }
}
catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}
?>