<?php include('header.php'); ?>
<head>
        <title>Notification preferences</title>
        <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>Change notification setting</h2>
    </div>
    <form method="post" action="index.php">
    <div class="input-group">
        <button type="submit" name="noti_on" class="btn">On</button>
        <button type="submit" name="noti_off" class="btn">Off</button>
    </div>
</body>
<?php include('footer.php'); ?>