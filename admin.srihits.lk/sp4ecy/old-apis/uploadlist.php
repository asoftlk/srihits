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
$type = $obj['type'];
if($type=='1')
{
  $query = mysqli_query($con,"select SQL_CALC_FOUND_ROWS * from videos where userid='$userid' order by datetime DESC limit $cal, $limit");
$total = mysqli_query($con,"SELECT FOUND_ROWS() as count");
$tot = mysqli_fetch_assoc($total);
$uplod=array();
while($row=mysqli_fetch_assoc($query)){
    $datetimeFromMysql=$row['datetime'];
    $time = strtotime($datetimeFromMysql);
    $row['datetime1'] = date("m/d/Y g:i A", $time);
    array_push($uplod,$row);}
$rtn = array('success'=>'true','list'=>$uplod,'count'=>(int)$tot['count']);  
}
else{
$query = mysqli_query($con,"select SQL_CALC_FOUND_ROWS videoid,displayname,type from videos where userid='$userid' and status='0' order by datetime DESC");
$total = mysqli_query($con,"SELECT FOUND_ROWS() as count");
$tot = mysqli_fetch_assoc($total);
$uplod=array();
while($row=mysqli_fetch_assoc($query)){
    array_push($uplod,$row);}
$rtn = array('success'=>'true','list'=>$uplod,'count'=>(int)$tot['count']);
}
echo json_encode($rtn);
?>