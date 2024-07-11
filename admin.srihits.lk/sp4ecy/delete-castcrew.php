<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
$userid = $_POST['userid'];
$id = $_POST['id'];

$query = mysqli_query($con,"delete from cast_crew where id='$id'");
if($query){
     $rtn = array('success'=>true,'message'=>'Cast/Crew deleted successfully');
}
else{$rtn = array('success'=>false,'message'=>'Cast/Crew not deleted');}
echo json_encode($rtn);
?>