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

//echo "Connected successfully";


 ?> 