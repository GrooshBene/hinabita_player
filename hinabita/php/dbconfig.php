<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    $conn = mysql_connect('localhost', 'hinabita', 'prec') or die("asdf");
    $db = mysql_select_db('hinabita', $conn);

    mysql_query('set names utf8');
?>
