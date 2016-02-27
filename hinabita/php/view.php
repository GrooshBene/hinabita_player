<?php
       error_reporting(E_ALL);
       ini_set("display_errors", 1);
       $conn = mysql_connect('localhost', 'hinabita', 'prec') or die("asdf");
       $db = mysql_select_db('hinabita', $conn);
   
       mysql_query('set names utf8');
       $musicId = $_GET['id'];
       $query = "SELECT * FROM MUSICLIST WHERE musicid='".$musicId."'";
      $result = mysql_query($query, $conn);
      while($data = mysql_fetch_array($result)){
          if($data == null){
              echo "<h1>wrong input!</h1>";
          }
          else{
          echo "<audio controls autoplay><source src='".$data[0]."' type='audio/mp3'>Your browser does not support this Player.</audio>";
          echo '<h1>title</h1><br><b>'.$data[1].'</b>';
             }
         }
  ?>
