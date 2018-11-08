<?php
require ('connect.php');
$id = $_GET['id'];
$sql = "DELETE FROM db_cking.pictures WHERE pic_id = $id;";
$stmt = $conn->prepare($sql);
$stmt->execute();
header("location:my_gallery.php");
?>