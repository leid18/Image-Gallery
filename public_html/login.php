<?php
ob_start();
session_start();
?>
<?php
$servername = "mysql.dur.ac.uk";
$username = "kxsg76";
$password = "wh25en";
$databasename="Xkxsg76_Image Gallery";

// Create connection
$conn = new mysqli($servername, $username, $password, $databasename);

// Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
} 

$email=$_POST['email1']; 
$password= $_POST['password1']; 


// Matching user input email and password with stored email and password in database.
$result = mysqli_query($conn,"SELECT * FROM registration WHERE email='$email' AND password='$password'");
$data = mysqli_num_rows($result);
if($data==1){
echo "Successfully Logged in...";

$_SESSION['email'] = '1';
}else{
echo "Email or Password is wrong...!!!!";
$_SESSION['email'] = '0';
}

mysqli_close ($conn); // Connection Closed.
?>