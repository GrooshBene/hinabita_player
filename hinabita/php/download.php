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
        $filepath = $data['apimusicurl'];
        $musicname = $data['musictitle'];
    };
    $filesize = filesize($filepath);
    $pathparts = pathinfo($filepath);
    
    header("Pragma: public");
    header("Expires: 0");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$musicname);
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$filesize);

    readfile($filepath);
?>

