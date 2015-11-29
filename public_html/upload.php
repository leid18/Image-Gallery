<?php
ob_start();
session_start();
?>
<?php
if ($_SESSION['email'] =="1"){
    $target_dir = "pictures/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $imageName = time().'.'.$imageFileType;
    $imagePath = "http://community.dur.ac.uk/cheng.peng/".$target_dir.$imageName;
    $imageSize = $_FILES["fileToUpload"]["size"] ;
    $thumbname = "thumb_".$imageName;
    $thumbpath = "http://community.dur.ac.uk/cheng.peng/pictures/thumbnails/".$thumbname;
    $servername = "mysql.dur.ac.uk";
    $username = "kxsg76";
    $password = "wh25en";
    $databasename="Xkxsg76_Image Gallery";

    function make_thumb($src, $dest, $desired_width) {

        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        
        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));
        
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        
        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        
        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $databasename);

    // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
    } 


    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
           // echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        //echo "Sorry, file already exists.";
        echo "<script language='javascript'>alert('Sorry, file already exists.');location='index.php';</script>";
        $uploadOk = 0;
    }
     // Check file size
    if ($_FILES["fileToUpload"]["size"] > 50000000) {
        //echo "Sorry, your file is too large.";
        echo "<script language='javascript'>alert('Sorry, your file is too large.');location='index.php';</script>";
        $uploadOk = 0;
     }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG" ){
        //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        echo "<script language='javascript'>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');location='index.php';</script>";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$imageName)) {
             $query_upload="INSERT into Image (ImageName,ImagePath,ImageSize,ThumbnailPath) VALUES ('$imageName','$imagePath','$imageSize','$thumbpath')";  

    		 mysqli_query($conn,$query_upload) or die("error in $query_upload == --> ".mysqli_error()); 
             $o = $target_dir.$imageName;
             $t = $target_dir."thumbnails/".$thumbname;
             make_thumb($o,$t,120);

    		
    		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    		//echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
            echo "<script language='javascript'>alert('uploaded!');location='index.php';</script>";
        } else {
            //echo "Sorry, there was an error uploading your file.";
            "<script language='javascript'>alert('Sorry, there was an error uploading your file.');location='index.php';</script>";
        }
    }
}else{
    echo "<script>alert('If you want to upload this ,try email:123@dur.ac.uk, password:123456,thank you!')</script>";
    echo "<script>window.location = 'http://community.dur.ac.uk/cheng.peng'</script>";
}
//header ("location:javascript://history.go(-1)");

?>