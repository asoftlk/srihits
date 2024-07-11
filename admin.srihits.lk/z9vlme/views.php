<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$id= $obj['id'];
$query = mysqli_query($con,"select * from viewsbyuser where videoid='$id'");
$ck = mysqli_num_rows($query);
if($ck>0){
    $query = mysqli_query($con,"update viewsbyuser set count=count+1 where videoid='$id'");
}
else{
    $query = "insert into viewsbyuser (videoid,count) values ('$id','1')";
    $em = mysqli_query($con,$query);
}
?>