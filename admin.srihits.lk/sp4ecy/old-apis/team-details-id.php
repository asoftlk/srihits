<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$id = $obj['id'];

$mdquery = mysqli_query($con,"select * from moviedetails  where  userid='$id' order by insertdatetime DESC");
$movie = array();
while($row=mysqli_fetch_assoc($mdquery)){
    $datetimeFromMysql=$row['insertdatetime'];
    $time = strtotime($datetimeFromMysql);
    $row['datetime1'] = date("m/d/Y g:i A", $time);
    array_push($movie,$row);}
    
$squery = mysqli_query($con,"select * from tvseriesdetails  where  userid='$id' order by insertdatetime DESC");
$series = array();
while($row=mysqli_fetch_assoc($squery)){
    $datetimeFromMysql=$row['insertdatetime'];
    $time = strtotime($datetimeFromMysql);
    $row['datetime1'] = date("m/d/Y g:i A", $time);
    array_push($series,$row);}
    
$vquery = mysqli_query($con,"select * from vsc  where  userid='$id' order by insertdatetime DESC");
$video = array();
while($row=mysqli_fetch_assoc($vquery)){
    $datetimeFromMysql=$row['insertdatetime'];
    $time = strtotime($datetimeFromMysql);
    $row['datetime1'] = date("m/d/Y g:i A", $time);
    array_push($video,$row);}
    
$rtn = array('success'=>'true','movielist'=>$movie,'serieslist'=>$series,'videolist'=>$video);
echo json_encode($rtn);
    
?>