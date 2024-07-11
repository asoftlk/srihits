<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$id = $obj['id'];
$gt = mysqli_query($con,"select name from subtitles where  id='$id'");
$row = mysqli_fetch_assoc($gt);
$imagePath = $row['name'];
$query = mysqli_query($con,"delete from subtitles where  id='$id'");
if($query){
    unlink($imagePath);
    $rtn=array('success'=>'true','message'=>'File deleted successfull');
}
else{$rtn=array('success'=>'false','message'=>'File deleted Failed');}
echo json_encode($rtn);
?>