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
    <div id="status"></div>
    <button onclick="takeSnapshot()" class="btn">Take pic</button>
	<button onclick="savePic()" class="btn">Save</button> 
</div>
</div>
<BR/><BR/>
<div id="container2"></div>
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

function takeSnapshot(){
      var context;
      var width = video.offsetWidth, height = video.offsetHeight;
      var sticker = new Image();
      sticker.src = "./img/frame1.png";

      canvas = canvas || document.createElement('canvas');
      canvas.width = width;
      canvas.height = height;

      context = canvas.getContext('2d');
      context.drawImage(video, 0, 0, width, height);
      context.drawImage(sticker,0,0,width, height);

      img.src = canvas.toDataURL('image/png');
      document.getElementById("container2").innerHTML = "<img src="+img.src+">";
      }

function savePic(){
    var hr = new XMLHttpRequest();
    var url = "server.php";
    var usr = '<?php echo $_SESSION["username"]; ?>';
    var pic = (encodeURIComponent(JSON.stringify(img.src)));
    var vars = "username="+usr+"&pic="+pic+"&submit_pic=true";
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
    if(hr.readyState == 4 && hr.status == 200) {
        var return_data = hr.responseText;
        document.getElementById("status").innerHTML = return_data;
    }
}
hr.send(vars);
document.getElementById("status").innerHTML = "processing...";
}
</script>
</body>
</html>