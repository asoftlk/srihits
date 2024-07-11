<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
if(isset($_POST['kids'])){
$kid=mysqli_real_escape_string($con, $_POST['kids']);
}
else{
$kid=$obj['kids'];   
}
$query = mysqli_query($con,"select * from sliderimages where arrange!=0 and kid='$kid' order by arrange DESC limit 5");
$images = array();
while($row=mysqli_fetch_assoc($query)){
    array_push($images,$row);
}
$rtn = array('data'=>$images);
echo json_encode($rtn);
?>