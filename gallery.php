<html>
<head>
<style>
div.gallery {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 20%;
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
</head>
<body>
<?php
require('connect.php');
$stmt = $conn->prepare("SELECT username,pic,pic_id FROM db_cking.pictures");
$stmt->execute();

while ($row = $stmt->fetch()) {
    echo('<div class="gallery">');
    echo('<a href="image.php?pic_id=');
    echo($row[pic_id].'">');
    echo("<img src =".$row[pic]."/>");
    echo('</a>');
    echo('<div class="desc">'.$row[username].'</div>');
    echo('</div>');
}
?>
</body>
</html>