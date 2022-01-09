<?php
// Sletter kommentar. 
require_once '/home/mir/lib/db.php';
$pid = $_GET['pid'];
$cid = $_GET['cid'];
$returnURL = 'indlæg.php?pid='.$pid;
delete_comment($cid);
header('Location:' .$returnURL);
?>
