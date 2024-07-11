<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
date_default_timezone_set("Asia/Kolkata");
$datetime = date('d-m-Y H:i:s');
$deviceinfo = $obj['info'];
$query = mysqli_query($con,"update device set lastlogin = '$datetime' where deviceinfo = '$deviceinfo'");
if($query){
    $rtn = array('success'=>true,'message'=>'updated','date'=>$datetime,'info'=>$deviceinfo);
}
else{
      $rtn = array('success'=>false,'message'=>'failed');
}
echo json_encode($rtn);
?>