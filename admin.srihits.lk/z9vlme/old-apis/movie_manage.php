<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
date_default_timezone_set("Asia/Kolkata");
$email = $obj['email'];
$type = $obj['type'];
$mobile = $obj['mobile'];
$id = $obj['id'];
$time1= date("Y-m-d H:i:s");
if($type=='0'){
    $query = "insert into movie_subcription(email,mobile,videoid,datetime,status)values('$email','$mobile','$id','$time1','1')";
    $ck = mysqli_query($con,$query);
    if($ck){
        $rtn = array('success'=>'true','message'=>'subscribed');
    }
    else{
        $rtn = array('success'=>'false','message'=>'Please try again');
    }
}

echo json_encode($rtn);
?>