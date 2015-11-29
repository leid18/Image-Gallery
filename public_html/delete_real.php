
<?php 
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
$desvalue=$_POST['des'];
	$upload = "update Image set ImageDescription= '$desvalue' where ID=".$id;
	$res=mysqli_query($conn,$upload);
	
	if($desvalue=""){
		echo "<script language='javascript'>alert('update failed!');location='index.php';</script>";
	}
	else
	{
		echo "<script language='javascript'>alert('updated!');location='index.php';</script>";

	}
}
?>