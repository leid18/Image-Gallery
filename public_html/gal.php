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

      $prow=2;
      $pcolumn=6;
      $totalPicturePerPage=12;
      
       if($_POST["paginate"])
       {
          $prow=$_POST["prow"];
          $pcolumn=$_POST["pcolumn"];
          $totalPicturePerPage=$prow*$pcolumn;
          echo "<script language='javascript'>alert($totalPicturePerPage);</script>";
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
             <p>$imagesize $imagedes</p>

             <form action='delete.php' method='post' align='left'>
             <input type='hidden' id='getid' name='getid' value='$imageid'>
             <input type='submit' name='submit' value='delete'></form>
             </a>
             <form action='edit.php' method='post' align='left'>
             <input type='hidden' id='getid' name='getid' value='$imageid'>
             <input type='submit' name='submit' value='edit'></form>
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

            function paginate_three($reload, $page, $tpages, $adjacents) {
            $prevlabel = "&lsaquo; Prev";
            $nextlabel = "Next &rsaquo;";
            
            $out = "<div class=\"pagin\">\n";
            
            // previous
            if($page==1) {
              $out.= "<span>" . $prevlabel . "</span>\n";
            }
            elseif($page==2) {
              $out.= "<a href=\"" . $reload . "\">" . $prevlabel . "</a>\n";
            }
            else {
              $out.= "<a href=\"" . $reload . "?page=" . ($page-1) . "\">" . $prevlabel . "</a>\n";
            }
            
            // first
            if($page>($adjacents+1)) {
              $out.= "<a href=\"" . $reload . "\">1</a>\n";
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
                $out.= "<a href=\"" . $reload . "\">" . $i . "</a>\n";
              }
              else {
                $out.= "<a href=\"" . $reload . "?page=" . $i . "\">" . $i . "</a>\n";
              }
            }
            
            // interval
            if($page<($tpages-$adjacents-1)) {
              $out.= "...\n";
            }
            
            // last
            if($page<($tpages-$adjacents)) {
              $out.= "<a href=\"" . $reload . "?page=" . $tpages . "\">" . $tpages . "</a>\n";
            }
            
            // next
            if($page<$tpages) {
              $out.= "<a href=\"" . $reload . "?page=" . ($page+1) . "\">" . $nextlabel . "</a>\n";
            }
            else {
              $out.= "<span>" . $nextlabel . "</span>\n";
            }
            
            $out.= "</div>";
            
            return $out;
          }
    echo paginate_three($reload, $page, $pagemax, $adjacents);

    mysqli_close($conn);
?>