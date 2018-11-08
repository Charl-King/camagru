<?php include('header.php'); ?>
<head>
        <title>Log in</title>
        <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>Change username</h2>
    </div>
    <form method="post" action="index.php">
    <?php include ('errors.php');?>
    <div class="input-group">
            <label>Username</label>
            <input type="text" name="new_username">
    </div>
    <div class="input-group">
        <button type="submit" name="change_username" class="btn">Change</button>
    </div>
</body>
<?php include('footer.php'); ?>