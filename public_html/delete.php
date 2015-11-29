<?php
ob_start();
session_start();
?>
<?php
if ($_SESSION['email'] =="1"){
	include("mysql.php");
	$id=$_POST['getid'];

	if($id){
		$sqli = "select * from Image where ID=".$id;
		$sqliname = "select ImageName from Image where ID=".$id;
		$tmpname = mysqli_query($conn,$sqliname);
		$delname_array = mysqli_fetch_assoc($tmpname);
		$delname = $delname_array['ImageName'];
		$delpath = "pictures/"."$delname";
		$ress = mysqli_query($conn,$sqli);
		$row=mysqli_fetch_array($ress);
		//echo $row['pic'];
		$sql = "delete from Image where ID=".$id;
		$res = mysqli_query($conn,$sql);
		$del=unlink($delpath);
	}
	if($res == true && $del==true)

		{echo "<script language='javascript'>alert('deleted!');location='index.php';</script>";}
		else
		{echo "<script language='javascript'>alert('delete failed!');location='index.php';</script>";}
}
else{
	echo "<script>alert('If you want to delete this ,try email:123@dur.ac.uk, password:123456,thank you!')</script>";
	echo "<script>window.location = 'http://community.dur.ac.uk/cheng.peng'</script>";
}
?>