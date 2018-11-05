<!DOCTYPE html>
<html>
<style>
#container {
    margin: 0px auto;
    width: 500px;
    height: 375px;
    border: 10px #333 solid;
}
</style>
<head>
	<title>Image view</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
	<h2>Image view</h2>
</div>
<div class="content">
</div>
<BR/><BR/>
<?php
$servername = "localhost";
$ad_username = "root";
$ad_password = "test";
$dbname = "db_cking";
$username = "";
$email = "";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
$stmt = $conn->prepare("SELECT username,pic FROM db_cking.pictures WHERE pic_id=$_GET[pic_id]");
$stmt->execute();

while ($row = $stmt->fetch()) {
    echo('<div id="container">');
    echo("<img src =".$row[pic]."/>");
    echo('</div>');
}
?>
</body>
<html>