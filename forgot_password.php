<?php 
include('server.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Log in</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
    <div class="header">
        <h2>Login</h2>
    </div>
    <form method="post" action="login.php">
    <?php include ('errors.php');?>
  	<?php if (isset($_SESSION['msg'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['msg']; 
          	unset($_SESSION['msg']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>
</div>
        <div class="input-group">
            <label>Email adress</label>
            <input type="text" name="email">
        </div>
        <div class="input-group">
            <button type="submit" name="pwrst" class="btn">Send reset</button>
        </div>
        <p>
            Not yet a member? <a href="register.php">Sign up</a> &emsp; <a href="forgot_password.php">Forgot password ?</a>
        </p>
    </form>
</body>
</html>