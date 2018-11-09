function takeSnapshot(){
      var context;
      var width = video.offsetWidth, height = video.offsetHeight;

      canvas = canvas || document.createElement('canvas');
      canvas.width = width;
      canvas.height = height;

      context = canvas.getContext('2d');
      context.drawImage(video, 0, 0, width, height);
      
      img.src = canvas.toDataURL('image/png');
      document.getElementById("container2").innerHTML = "<img style='width:100%; height:100%;' src="+img.src+">";
      }

function savePic(usr){
    var hr = new XMLHttpRequest();
    var url = "server.php";
    var pic = (encodeURIComponent(JSON.stringify(img.src)));
    if(img.src != ''){
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
}

function addSticker(path){
    var sticker = new Image();
    var width = video.offsetWidth, height = video.offsetHeight;
    sticker.src = path;
    if (canvas){
        contxt = canvas.getContext('2d');
        contxt.drawImage(sticker,0,0,width, height);
        img.src = canvas.toDataURL('image/png');
        document.getElementById("container2").innerHTML = "<img src="+img.src+">";
    }
    else{
        document.getElementById("container2").innerHTML = "Take a picture first."; 
    }
}

function upload_picture() {

    var context;
    var width = video.offsetWidth, height = video.offsetHeight;

    canvas = canvas || document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;

	var file = document.querySelector('input[type=file]').files[0];
	var reader  = new FileReader();

	reader.onloadend = function () {
		var img2 = new Image();
		img2.onload = function () {
			canvas.getContext('2d').drawImage(img2,0, 0, width, height);
		}
        img2.src = reader.result;
        document.getElementById("container2").innerHTML = "<img style='width:100%; height:100%;'src="+img2.src+">";
	};
    reader.readAsDataURL(file);
}