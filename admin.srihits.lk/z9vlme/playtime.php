<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$id= $obj['id'];
$userid = $obj['userid'];
$status = $obj['status'];
$duration = $obj['duration'];
$query = mysqli_query($con,"select * from playtime where userid = '$userid' and videoid = '$id'");
$ck = mysqli_num_rows($query);
if($ck>0){
    $que = mysqli_query($con,"update playtime set duration='$duration' where userid = '$userid' and videoid = '$id'");
    if($que){$rtn = array('success'=>'true');}
    else{$rtn = array('success'=>'fail');}
}
else{
    $que = "insert into playtime (userid,videoid,duration,status) values('$userid','$id','$duration','$status')";
    $cko = mysqli_query($con,$que);
    if($cko){$rtn = array('success'=>'true');}
    else{$rtn = array('success'=>'false');}
}
echo json_encode($rtn);
?>