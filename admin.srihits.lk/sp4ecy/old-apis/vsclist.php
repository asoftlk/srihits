<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$limit = $obj['limit'];
$offset = $obj['offset'];
$cal = $limit * ($offset-1);
$userid = $obj['userid'];
$type = $obj['type'];
$role = $obj['role'];
if($role=='Admin'){
$mdquery = mysqli_query($con,"select SQL_CALC_FOUND_ROWS * from vsc inner join thumbnail where vsc.videoid=thumbnail.videoid and thumbnail.type='thumbnail'and vsc.type='$type' order by datetime DESC limit $cal, $limit");}
else if($role=='Manager'){
    $mdquery = mysqli_query($con,"select SQL_CALC_FOUND_ROWS * from vsc inner join thumbnail where vsc.videoid=thumbnail.videoid and thumbnail.type='thumbnail'and vsc.userid='$userid' and vsc.type='$type' order by datetime DESC limit $cal, $limit");
}
else{
    $mdquery = mysqli_query($con,"select SQL_CALC_FOUND_ROWS * from vsc inner join thumbnail where vsc.videoid=thumbnail.videoid and thumbnail.type='thumbnail'and vsc.userid='$userid' and vsc.type='$type' order by datetime DESC limit $cal, $limit");
}
$total = mysqli_query($con,"SELECT FOUND_ROWS() as count");
$tot = mysqli_fetch_assoc($total);
$mdetails = array();
while($row=mysqli_fetch_assoc($mdquery)){array_push($mdetails,$row);}

$rtn = array('success'=>'true','vsclist'=>$mdetails,'count'=>(int)$tot['count']);
echo json_encode($rtn);
?>