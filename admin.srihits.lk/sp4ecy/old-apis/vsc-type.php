<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$userid = $obj['userid'];
$role = $obj['role'];
$type = $obj['type'];
$category = $obj['category'];
$movielist=array();
$mquery=mysqli_query($con,"select id,videoid,displayname from videos where type='$type' and userid='$userid' and category='$category'");
while($row=mysqli_fetch_assoc($mquery)){array_push($movielist,$row);}

$rtn = array('success'=>'true','vscnames'=>$movielist);
echo json_encode($rtn);
?>