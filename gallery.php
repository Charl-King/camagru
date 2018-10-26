<?php
$servername = "localhost";
$ad_username = "root";
$ad_password = "test";
$dbname = "db_cking";
$username = "";
$email = "";


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password, $opt);
$stmt = $conn->prepare("SELECT pic FROM db_cking.pictures");

//$results = $stmt->fetchAll();
//echo ("<img src =".$results[0][pic]."/>");

$stmt->execute();
$i = 0;
while ($row = $stmt->fetch()) {
    echo("<img src =".$row[pic]."/>");
    $i++;
}

?>