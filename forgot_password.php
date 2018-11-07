<?php include('header.php'); ?>
<?php 
include('server.php');
?>
    <head>
        <title>Password recovery</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
    <div class="header">
        <h2>Password recovery</h2>
    </div>
    <form method="post" action="password_reset.php">
</div>
        <div class="input-group">
            <label>Email adress</label>
            <input type="text" name="email">
        </div>
        <div class="input-group">
            <button type="submit" name="pwrst" class="btn">Send reset</button>
        </div>
        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>
</body>
<?php include('footer.php'); ?>