<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
// header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$userid = $obj['userid'];
$role = $obj['role'];
$type = $obj['type'];
$movielist=array();
$mquery=mysqli_query($con,"select id,videoid,displayname from videos where type='$type' and userid='$userid' and category='video'");
while($row=mysqli_fetch_assoc($mquery)){array_push($movielist,$row);}

$tvlist=array();
$tquery=mysqli_query($con,"select videoid,displayname from videos where type='$type'and userid='$userid'and category='trailer'");
while($row=mysqli_fetch_assoc($tquery)){array_push($tvlist,$row);}

$queryS = mysqli_query($con,"select * from sliderimages where userid='$userid'");
$listS = array();
while($row=mysqli_fetch_assoc($queryS)){array_push($listS,$row);}

$rtn = array('success'=>'true','movienames'=>$movielist,'trailernames'=>$tvlist,'sliderlist'=>$listS);
echo json_encode($rtn);
?>