<?php include('header.php'); ?>
    <head>
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
    <div class="header">
        <h2>Register</h2>
    </div>
    <form method="post" action="register.php">
    <?php include ('errors.php');?>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password_1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <button type="submit" name="register" class="btn">Register</button>
        </div>
        <p>
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </form>
</body>
<?php include('footer.php'); ?>