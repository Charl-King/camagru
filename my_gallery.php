<?php include('header.php'); ?>
<style>
div.gallery {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 32%;
}

div.gallery:hover {
    border: 1px solid #779;
}

div.gallery img {
    width: 100%;
    height: auto;
}

div.desc {
    padding: 8px;
    text-align: center;
}
</style>
<head>
	<title>My gallery</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
require('connect.php');
$username = $_SESSION['username'];
$sql = "SELECT pic,pic_id FROM db_cking.pictures WHERE username = '$username'";
$stmt = $conn->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch()) {
    echo('<div class="gallery">');
    echo('<a href="image.php?pic_id=');
    echo($row['pic_id'].'">');
    echo("<img src =".$row['pic']."/>");
    echo('</a>');
    echo('<div class="desc"><a href="delete_pic.php?id='.$row['pic_id'].'">Delete</div>');
    echo('</a></div>');
}
?>
</body>
<?php include('footer.php'); ?>