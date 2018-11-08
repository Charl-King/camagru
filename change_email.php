<?php include('header.php'); ?>
<head>
        <title>Change email</title>
        <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>Change email</h2>
    </div>
    <form method="post" action="index.php">
    <?php include ('errors.php');?>
    <div class="input-group">
            <label>New email</label>
            <input type="text" name="new_email">
    </div>
    <div class="input-group">
        <button type="submit" name="change_email" class="btn">Change</button>
    </div>
</body>
<?php include('footer.php'); ?>