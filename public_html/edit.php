<?php
ob_start();
session_start();
?>
<?php 

if ($_SESSION['email'] =="1"){
include ("mysql.php");
$id=$_POST['getid'];
if($id){
	$query_path= "select ImagePath from Image where ID =".$id;
	$tmppath=mysqli_query($conn,$query_path);
	$imagepath_array = mysqli_fetch_assoc($tmppath);
	$imagepath = $imagepath_array['ImagePath'];
	$query_description="select ImageDescription from Image where ID=".$id;
	$tmpdes=mysqli_query($conn,$query_description);
	$imagedes_array=mysqli_fetch_assoc($tmpdes);
	$imagedes=$imagedes_array['ImageDescription'];


	echo "
	<img src=\"$imagepath\" width=\"500px\" height=\"300px\"></br>
	please enter the description here:<br>
	<form action='edit_real.php' method='post' align='left'>
	<input type='text' name='des' size = '50px' value='$imagedes'>
	 <input type='hidden' id='getid' name='getid' value='$id'>
	<input type='submit' name='submit' value='submit'></form>
	<form action='cancel.php' method='post'><input type='submit' id = 'cancel' name='cancel' value='cancel'></form>
	";

	}
}else
{
	echo "<script>alert('If you want to edit this ,try email:123@dur.ac.uk, password:123456,thank you!')</script>";
	echo "<script>window.location = 'http://community.dur.ac.uk/cheng.peng'</script>";
}
?>


