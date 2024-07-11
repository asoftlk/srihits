<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$limit = $obj['limit'];
$offset = $obj['offset'];
$cal = $limit * ($offset-1);
$userid = $obj['userid'];
$qry = $obj['query'];
$type=$obj['status'];
$kid=$obj['kid'];
if($type=='1'){
    $query = mysqli_query($con,"select SQL_CALC_FOUND_ROWS * from sliderimages where userid='$userid' and kid='$kid' order by datetime DESC limit $cal, $limit");
}
else{
   $query = mysqli_query($con,"select SQL_CALC_FOUND_ROWS * from sliderimages  where sliderimages.displayname like '%$qry%' and userid='$userid'  and kid='$kid' order by datetime DESC limit $cal, $limit"); 
}
$total = mysqli_query($con,"SELECT FOUND_ROWS() as count");
$tot = mysqli_fetch_assoc($total);
$images=array();
while($row=mysqli_fetch_assoc($query)){
    $datetimeFromMysql=$row['datetime'];
    $time = strtotime($datetimeFromMysql);
    $row['datetime1'] = date("m/d/Y g:i A", $time);
    array_push($images,$row);}
$rtn = array('success'=>'true','list'=>$images,'count'=>(int)$tot['count']);
echo json_encode($rtn);
?>