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

<!DOCTYPE html>
<html>
<style>
#container {
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
	<div class="input-group">
    <button onclick="takeSnapshot" class="btn">Take pic</button>
</div>
<a id="dl-btn" href="#" download="glorious_selfie.png" class="btn">Save Photo</a>
</div>

<script>
var video = document.querySelector("#videoElement");
	
	if (navigator.mediaDevices.getUserMedia) {       
		navigator.mediaDevices.getUserMedia({video: true})
	.then(function(stream) {
		video.srcObject = stream;
		return vid.play(); // returns a Promise
	})
	}

function takeSnapshot(){

		
		var hidden_canvas = document.querySelector('canvas'),
		video = document.querySelector('video.camera_stream'),
		image = document.querySelector('img.photo'),

		// Get the exact size of the video element.
		width = video.videoWidth,
		height = video.videoHeight,

		// Context object for working with the canvas.
		context = hidden_canvas.getContext('2d');

		// Set the canvas to the same dimensions as the video.
		hidden_canvas.width = width;
		hidden_canvas.height = height;

		// Draw a copy of the current frame from the video on the canvas.
		context.drawImage(video, 0, 0, width, height);

		// Get an image dataURL from the canvas.
		var imageDataURL = hidden_canvas.toDataURL('image/png');

		// Set the dataURL as source of an image element, showing the captured photo.
		image.setAttribute('src', imageDataURL);

		// Set the href attribute of the download button.
		document.querySelector('#dl-btn').href = imageDataURL;

}
</script>
</body>
</html>