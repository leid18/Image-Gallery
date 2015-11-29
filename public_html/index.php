<?php
ob_start();
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
    $("#login").click(function(){
    var email = $("#email").val();
    var password = $("#password").val();
    // Checking for blank fields.
    if( email =='' || password ==''){
    $('input[type="text"],input[type="password"]').css("border","2px solid red");
    $('input[type="text"],input[type="password"]').css("box-shadow","0 0 3px red");
    alert("Please fill all fields...!!!!!!");
    }else {
    $.post("login.php",{email1: email, password1:password},
    function(data) {
    if(data=='Invalid Email.......') {
    $('input[type="text"]').css({"border":"2px solid red","box-shadow":"0 0 3px red"});
    $('input[type="password"]').css({"border":"2px solid #00F5FF","box-shadow":"0 0 5px #00F5FF"});
    alert(data);
    }else if(data=='Email or Password is wrong...!!!!'){
    $('input[type="text"],input[type="password"]').css({"border":"2px solid red","box-shadow":"0 0 3px red"});
    alert(data);
    } else if(data=='Successfully Logged in...'){
    $("form")[0].reset();
    $('input[type="text"],input[type="password"]').css({"border":"2px solid #00F5FF","box-shadow":"0 0 5px #00F5FF"});
    alert(data);
    } else{
    alert(data);
    }
    });
    }
    });
    });
    </script>
   <script type="text/javascript">
      // <![CDATA[
      (function(d, s, id) {
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) return;
       js = d.createElement(s); js.id = id; 
       js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=312758362262804&version=v2.0";
       fjs.parentNode.insertBefore(js, fjs);
       }(document, "script", "facebook-jssdk"));

      // ]]>
      </script>
      <meta http-equiv="content-type" content="text/xml; charset=utf-8"/>
      <link rel="stylesheet" type="text/css" href="mystyle.css">
      <link rel="stylesheet" type="text/css" href="paginate.css">
</head>
<body> 
  <div id="head"> <h1>Cheng's Image Gallery</h1> </div>
  <div id="nav">
    <form class="form" method="post" action="#">
    <label>Email :</label>
    <input type="text" name="email" id="email"><br>
    <label>Password :</label>
    <input type="password" name="password" id="password">
    <input type="button" name="login" id="login" value="Login">
    </form>
          <h1 id="fb-welcome"></h1>
          <div id="fb-root"></div>
          <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="true" data-auto-logout-link="true"> </div>
          <form action="upload.php" method="post" enctype="multipart/form-data">
              Select image to upload:
              <input type="file" name="fileToUpload" id="fileToUpload">
              <input type="submit" value="Upload Image" name="submit">
          </form>
  </div>

  <div id="section">
      <form method="post" align="left">
        Display rows:
        <select id="prow" name="prow">
           <option value="1">One</option>
           <option selected value="2">Two</option>
           <option value="3">Three</option>
           <option value="4">Four</option>
        </select>
        Images per row:
       <select id="pcolumn" name="pcolumn">
           <option value="3">Three</option>
           <option value="4">Four</option>
           <option value="5">Five</option>
           <option selected value="6">Six</option>
        </select>
        <input type="submit" name="paginate" value="confirm"/>
      </form>
  
    <table width="70%" height="70%">
    <tr></tr>
       <div class="content">edit.php</div> 
    </div> 
    </script>

      <?php 
 
      include "mysql.php"; 
     // include "initializeSDK.php";
      $query_select= "SELECT * FROM Image";
      $result=mysqli_query($conn,$query_select);
  
      function mysqli_result($res,$row=0,$col=0){
        if ($row >= 0 && mysqli_num_rows($res) > $row){
        mysqli_data_seek($res,$row);
        $resrow = mysqli_fetch_row($res);
          if (isset($resrow[$col])){
           return $resrow[$col];
          } 
        }
        return false;
      }

      $i=0;
      if (isset($_GET["page"])){
        $page = intval($_GET["page"]);}
      else{
        $page=1;
      }

      
        if(isset($_GET["gprow"]))
       {
          $prow= intval($_GET["gprow"]);
          $pcolumn = intval($_GET["gpcolumn"]);
          $totalPicturePerPage= $prow*$pcolumn;
       } 
       else {
        $prow=2;
        $pcolumn=6;
        $totalPicturePerPage=12;
       }
      
      
       if($_POST["paginate"])
       {
          $prow=$_POST["prow"];
          $pcolumn=$_POST["pcolumn"];
          $totalPicturePerPage=$prow*$pcolumn;
       } 


      
      $max=($page-1)*$totalPicturePerPage;
      $tmax=$page*$totalPicturePerPage;
      $num=mysqli_num_rows($result);
      $i=$max;
      $pagemax =($num)? ceil($num/$totalPicturePerPage):1;
      
      if ($pagemax == $page) {
        $tmax = $num;
      }

        while($i<$tmax)
        {
         $imageid=mysqli_result($result,$i,0);
         $imagename=mysqli_result($result,$i,1);
         $imagepath=mysqli_result($result,$i,2);
         $imagesize=mysqli_result($result,$i,3);
         $imagedes=mysqli_result($result,$i,4);
         $thumbpath=mysqli_result($result,$i,5);

             echo "<td><a target='_blank' href='$imagepath'>
             $imagename </br>
             <img src='$thumbpath' width='120px' height='120px'> </br>

             <form action='detail.php' method='post' align='left'>
             <input type='hidden' id='getid' name='getid' value='$imageid'>
             <input type='submit' id='detail' name='submit' value='detail'></form>
             </td> ";
              $image_per_row= $pcolumn;
              if($i%$image_per_row==$image_per_row-1)
              {
                echo "<tr></tr>";
              }
              $i++;
            }
            $adjacents = $prow;
            $reload = $_SERVER["PHP_SELF"];

            function paginate_three($reload, $page, $tpages, $adjacents, $prow, $pcolumn) {
            $prevlabel = "&lsaquo; Prev";
            $nextlabel = "Next &rsaquo;";
            
            $out = "<div class=\"pagin\">\n";
            
            // previous
            if($page==1) {
              $out.= "<span>" . $prevlabel . "</span>\n";
            }
            elseif($page==2) {
              $out.= "<a href=\"" . $reload . "?gprow=".$prow."&gpcolumn=".$pcolumn."\">" . $prevlabel . "</a>\n";
            }
            else {
              $out.= "<a href=\"" . $reload . "?page=" . ($page-1) . "&gprow=".$prow."&gpcolumn=".$pcolumn."\">" . $prevlabel . "</a>\n";
            }
            
            // first
            if($page>($adjacents+1)) {
              $out.= "<a href=\"" . $reload . "?gprow=".$prow."&gpcolumn=".$pcolumn."\">1</a>\n";
            }
            
            // interval
            if($page>($adjacents+2)) {
              $out.= "...\n";
            }
            
            // pages
            $pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
            $pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
            for($i=$pmin; $i<=$pmax; $i++) {
              if($i==$page) {
                $out.= "<span class=\"current\">" . $i . "</span>\n";
              }
              elseif($i==1) {
                $out.= "<a href=\"" . $reload . "?gprow=".$prow."&gpcolumn=".$pcolumn."\">" . $i . "</a>\n";
              }
              else {
                $out.= "<a href=\"" . $reload . "?page=" . $i . "&gprow=".$prow."&gpcolumn=".$pcolumn."\">" . $i . "</a>\n";
              }
            }
            
            // interval
            if($page<($tpages-$adjacents-1)) {
              $out.= "...\n";
            }
            
            // last
            if($page<($tpages-$adjacents)) {
              $out.= "<a href=\"" . $reload . "?page=" . $tpages . "&gprow=".$prow."&gpcolumn=".$pcolumn."\">" . $tpages . "</a>\n";
            }
            
            // next
            if($page<$tpages) {
              $out.= "<a href=\"" . $reload . "?page=" . ($page+1) . "&gprow=".$prow."&gpcolumn=".$pcolumn."\">" . $nextlabel . "</a>\n";
            }
            else {
              $out.= "<span>" . $nextlabel . "</span>\n";
            }
            
            $out.= "</div>";
            
            return $out;
          }      
    echo paginate_three($reload, $page, $pagemax, $adjacents, $prow, $pcolumn);
    echo "<tr></tr>";

    mysqli_close($conn);
?>
    </table>
  </div>
<div id="footer"> 2014 by Cheng Peng</br>School of Engineering and Computing Sciences, Durham University</div>
</body>
</html>



