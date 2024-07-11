<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$id = $obj['id'];
$status=$obj['status'];
$type=$obj['type'];
if($type=='movie'){
    $query = mysqli_query($con,"update moviedetails set publish='$status' where videoid='$id'");
    if($query){
        $rtn=array('success'=>'true','message'=>'Status changed successfull');
    }
    else{
        $rtn=array('success'=>'false','message'=>'Status not changed');
    }
}
else if($type=='series'){
      $query = mysqli_query($con,"update tvseriesdetails set publish='$status' where videoid='$id'");
    if($query){
        $rtn=array('success'=>'true','message'=>'Status changed successfull');
    }
    else{
        $rtn=array('success'=>'false','message'=>'Status not changed');
    }
}
else if($type=='vsc'){
      $query = mysqli_query($con,"update vsc set publish='$status' where videoid='$id'");
    if($query){
        $rtn=array('success'=>'true','message'=>'Status changed successfull');
    }
    else{
        $rtn=array('success'=>'false','message'=>'Status not changed');
    }
}
echo json_encode($rtn);
?>