<?php 
include('server.php');
?>
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
<div id="container">
    <?php
    require('connect.php');
    $stmt = $conn->prepare("SELECT username,pic FROM db_cking.pictures WHERE pic_id=$_GET[pic_id]");
    $stmt->execute();
    $row = $stmt->fetch();
    echo("<img src =".$row[pic]."/>");
    ?>
</div>
<form method="post" action=<?php echo "image.php?pic_id=".$_GET[pic_id]?>>
<div class="input-group" style="text-align:center;">
    <div style="width:80%; display:inline-block;">
        <label>Comment</label>
        <input type="text" name="comment">
    </div>
    <div class="input-group">
        <button type="submit" name="post" class="btn">Post</button>
    </div>
    <input type="hidden" id="pic_id" name="pic_id" value=<?php echo $_GET[pic_id]?>>
</div>
</form>
<div id="container">
<?php
    $stmt = $conn->prepare("SELECT comment FROM db_cking.comments WHERE pic_id=$_GET[pic_id] ORDER BY sub_datetime DESC LIMIT 5");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        echo($row[comment]);
        echo "<br>";
    }
?>
</div>
</body>
<html>