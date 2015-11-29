<html>
<?php 
	include ("mysql.php");
	$id=$_POST['getid'];
	if($id){
	$query= "select * from Image where ID =".$id;
	$tmp=mysqli_query($conn,$query);
	$image_array = mysqli_fetch_assoc($tmp);
	$imagepath = $image_array['ImagePath'];
	$imagename = $image_array['ImageName'];
	$imagesize = $image_array['ImageSize'];
	$imagedes = $image_array['ImageDescription'];
	$imagekb = $imagesize/1024;
	echo "
		<img src=\"$imagepath\" width=\"500px\" height=\"300px\"></br>
		Image name :<br>
		<P> $imagename </p>
		Image size : <br>
		<p> $imagekb kb</p>
		Image description :<br>
		<p> $imagedes </p>
		<form action='delete.php' method='post' align='left'>
		<input type='hidden' id='getid' name='getid' value='$id'>
		<input type='submit' name='delete' value='delete'></form>
        <form  action='edit.php' method='post' align='left'>
        <input type='hidden' id='getid' name='getid' value='$id'>
        <input type='submit' id='edit' name='edit' value='edit'></form>
        ";

}
?>
<a href="index.php">return</a>




</html>