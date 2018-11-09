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

//set page number
if (!isset($_GET['page'])) {
    $page = 1;
} else{
    $page = $_GET['page'];
}

//get number of entries in gallery
$limit = 6;
$query = "SELECT COUNT(pic_id) FROM db_cking.pictures WHERE username = '$username'";
$s = $conn->prepare($query);
$s->execute();
$count = $s->fetch()['COUNT(pic_id)'];
$total_pages = ceil($count/$limit);
$starting_limit = ($page - 1) * $limit;

//get $limit amount of pictures to display on the current page
$sql="SELECT `pic`,`pic_id` FROM db_cking.pictures WHERE username = '$username' ORDER BY sub_datetime DESC LIMIT $starting_limit, $limit ";
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
</div>
<BR style="clear: both;"/><BR/>

</body>
<div>
<?php for ($page=1; $page <= $total_pages ; $page++):?>

<a href='<?php echo "?page=$page"; ?>'><?php  echo $page; ?></a>
<?php endfor; ?>
</div>
<?php include('footer.php'); ?>