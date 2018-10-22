<?php 
include('server.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Password recovery</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
    <div class="header">
        <h2>Password recovery</h2>
    </div>
    <form method="post" action="login.php">
    </div>
        <div class="input-group">
            <label>Password</label>
            <input type="text" name="password_1">
        </div>
        <div class="input-group">
            <label>Confirm</label>
            <input type="text" name="password_2">
        </div>
        <div class="input-group">
            <button type="submit" name="changepw" class="btn">Set new password</button>
        </div>
    </form>
</body>
</html>