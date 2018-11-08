<?php include('header.php'); ?>
<!DOCTYPE html>
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
<div id="container" style="position:relative">
    <?php
    require('connect.php');
    $stmt = $conn->prepare("SELECT username,pic FROM db_cking.pictures WHERE pic_id=$_GET[pic_id]");
    $stmt->execute();
    $row = $stmt->fetch();
    echo("<img src =".$row['pic']."/>");
    ?>
    <div style="position:absolute;left:0;top:0;">
    <button onclick="Like(<?php echo($_GET['pic_id'])?>)" class="btn">Like</button>
    </div>
</div>
<form method="post" action=<?php echo "image.php?pic_id=".$_GET['pic_id']?>>
<div class="input-group" style="text-align:center;">
    <div style="width:80%; display:inline-block;">
        <label>Comment</label>
        <input type="text" maxlength="56" name="comment">
    </div>
    <div class="input-group">
        <button type="submit" name="post" class="btn">Post</button>
       
    </div>
    <input type="hidden" id="pic_id" name="pic_id" value=<?php echo $_GET['pic_id']?>>
</div>
</form>
<div id="container" style="height:20px">
Likes:
<?php
    $stmt = $conn->prepare("SELECT likes FROM db_cking.pictures WHERE pic_id=$_GET[pic_id]");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        echo($row['likes']);
        echo "<br>";
    }
?>
</div>
<div id="container" style="height:150px">
<?php
    $stmt = $conn->prepare("SELECT comment FROM db_cking.comments WHERE pic_id=$_GET[pic_id] ORDER BY sub_datetime DESC LIMIT 5");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        echo($row['comment']);
        echo "<br>";
    }
?>
<script>
function Like(pic_id){
    var hr = new XMLHttpRequest();
    var url = "server.php";
    var vars = "pic_id="+pic_id+"&like_pic=true";
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.send(vars);
    window.location = 'image.php?pic_id='+<?php echo $_GET['pic_id']?>;
}
</script>
</div>
</body>
<?php include ('footer.php')?>