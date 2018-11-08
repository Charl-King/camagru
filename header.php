<?php include ('server.php') ?>
<!DOCTYPE html>
<html>
<head>
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #111;
}

.right{
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    float: right;
}
</style>
</head>
<body>

<ul>
  <li><a class="active" href="index.php">Home</a></li>
  <li><a href="settings.php">Settings</a></li>
  <li><a href="settings.php">My Gallery</a></li>
  <li><a href="gallery.php">Gallery</a></li>
  <li><a href="logout.php">Logout</a></li>
  <li class="right"><?php echo ($_SESSION['username']); ?></li>
</ul>
</body>