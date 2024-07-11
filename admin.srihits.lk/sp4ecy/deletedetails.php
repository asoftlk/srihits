<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$id = $obj['id'];
$type = $obj['type'];
if($type=='movie'){
    $query = mysqli_query($con,"delete from moviedetails  where videoid='$id'");
    if($query){
        $rtn=array('success'=>'true','message'=>'Movie details deleted successfull');
    }
    else{
        $rtn=array('success'=>'false','message'=>'Movie details not deleted');
    } 
}
 else if($type=='series'){
      $query = mysqli_query($con,"delete from tvseriesdetails  where videoid='$id'");
    if($query){
        $rtn=array('success'=>'true','message'=>'Details deleted successfull');
    }
    else{
        $rtn=array('success'=>'false','message'=>'Details not deleted');
    }
 }
 else if($type=='vsc'){
      $query = mysqli_query($con,"delete from vsc  where videoid='$id'");
    if($query){
        $rtn=array('success'=>'true','message'=>'Details deleted successfull');
    }
    else{
        $rtn=array('success'=>'false','message'=>'Details not deleted');
    }
 }
 
echo json_encode($rtn);
?>