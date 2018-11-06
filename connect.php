<?php
$servername = "localhost";
$ad_username = "root";
$ad_password = "test";
$dbname = "db_cking";

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password, $opt);
?>