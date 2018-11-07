<?php include('header.php'); ?>
<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');

	  
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
	header("location: login.php");

  }
?>
<style>
#container {
    margin: 0px auto;
    width: 500px;
    height: 375px;
    border: 10px #333 solid;
}
#container2 {
    margin: 0px auto;
    width: 500px;
    height: 375px;
    border: 10px #333 solid;
}
#videoElement {
    width: 500px;
    height: 375px;
    background-color: #666;
}
</style>

<head>
	<title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="scripts.js"></script>
</head>
<body>
<div class="header">
	<h2>Home Page</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">Logout</a> </p>
    <?php endif ?>
</div>
<BR/><BR/>
<div id="container">
    <video autoplay="true" id="videoElement">
    </video>
    <div class="input-group" style="text-align:center;">
    <div id="status"></div>
    <div style="display:inline-block;">
    <button onclick="takeSnapshot()" class="btn">Take pic</button>
    <button onclick="savePic('<?php echo $_SESSION['username']; ?>')" class="btn">Save</button> 
</div>
</div>
</div>
<script>
    var video = document.querySelector("#videoElement"), canvas;
    var img = document.querySelector('img') || document.createElement('img');
	
	if (navigator.mediaDevices.getUserMedia) {       
		navigator.mediaDevices.getUserMedia({video: true})
	.then(function(stream) {
		video.srcObject = stream;
		return video.play(); // returns a false Promise
	})
	}
</script>
<BR>
<BR>
<BR>
<div id="container2"></div>
<div style="text-align:center;">
<div style="display:inline-block;">
    <button onclick="addSticker('./img/circle.png')" class="btn">Circle</button>
    <button onclick="addSticker('./img/frame1.png')" class="btn">Frame</button>
    <button onclick="addSticker('./img/imagination.png')" class="btn">Imagination</button>

</div>
</div>
</body>
<?php include ('footer.php')?>