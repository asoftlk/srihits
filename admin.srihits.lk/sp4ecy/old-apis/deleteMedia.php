<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$id=$obj['id'];
$type=$obj['type'];
$query = mysqli_query($con,"delete from videos where videoid='$id'");
if($query){
    if($type=='movie'){
      $query1=mysqli_query($con,"delete from moviedetails where videoid='$id'");
    if($query1){
        $rtn=array('success'=>'true','message'=>'Media File deleted successfull');
    }
    else{
        $rtn=array('success'=>'fail','message'=>'Movie details not deleted ');
    }
    }
    else if($type=='series'){
        $query1=mysqli_query($con,"delete from tvseriesdetails where videoid='$id'");
    if($query1){
        $rtn=array('success'=>'true','message'=>'Media File deleted successful');
    }
    else{
        $rtn=array('success'=>'fail','message'=>'Series details not deleted ');
    }
    }
    else{
        
    }
}
else{
    $rtn=array('success'=>'fail','message'=>'Media File not deleted ');
}
echo json_encode($rtn);

?>