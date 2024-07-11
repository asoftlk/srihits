<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
$userid = $_POST['userid'];
$list=[];
$getList=mysqli_query($con,"select * from cast_crew where userid='$userid'");
$count=mysqli_num_rows($getList);
if($count>0){$list=$getList->fetch_all(MYSQLI_ASSOC);}
$rtn = array('success'=>true,'data'=>$list);
echo json_encode($rtn);
?>