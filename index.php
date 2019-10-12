<?php
function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
         $newwidth = $w;
        $newheight = $h;
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	imagejpeg($dst, $file);
    return $dst;
}
if(isset($_FILES['imageurl']['name'])){
	move_uploaded_file($_FILES['imageurl']['tmp_name'],'images/'.$_FILES['imageurl']['name']);
	$img = resize_image('images/'.$_FILES['imageurl']['name'], $_POST['width'], $_POST['height']);
}
$directory = "images";
$images = glob($directory . "/*.jpg");


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">       
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="js/jquery.min.js"></script>
        <link rel="stylesheet" href="css/main.css" />
	</head>
	<body >
	
<div id="wrapper">
<div id="main">
<form  method="post" enctype="multipart/form-data" class="formSbmt">
  <label>Image URL : </label><input type="file" name="imageurl" accept="image/jpg" required></br>
  <label>Width </label><input type="text" name="width" required></br>
  <label>Height </label><input type="text" name="height" required></br>
  <input type="submit" value="Submit">
</form>
<div class="output">
Output
<table style="width:100%">
  <tr>
    <th>Image</th>
    <th>Width</th>
    <th>Height</th>
  </tr>
  <?php 
  foreach($images as $image){
	  list($width, $height) = getimagesize($image);
		echo '<tr>';
		echo '<td><img src="'.$image.'" width="100" height="100"/></td>';
		echo '<td>'.$width.'</td>';
		echo '<td>'.$height.'</td>';
		echo '</tr>'; 
	}
  ?>
  
     
</table>
</div>
</div>
</div>
	</body>
	</html>