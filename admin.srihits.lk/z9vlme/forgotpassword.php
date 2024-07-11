<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$email = $obj['email'];
$type = $obj['type'];
$password = $obj['password'];
$id = $obj['id'];
$encrypt = password_hash($password, PASSWORD_BCRYPT);
if($type=='check')
{
    $query = mysqli_query($con,"select * from appusers where email='$email' or mobilenumber = '$email'");
    $chk = mysqli_num_rows($query);
    $abc = mysqli_fetch_assoc($query);
    $uid = $abc['id'];
    if($chk>0)
    {
        $rtn = array('success'=>'true','message'=>'Account exists','id'=>$uid);
    }
    else{
        $rtn = array('success'=>'false','message'=>'user not exists');
    }
}
else{
   $quey = mysqli_query($con,"update appusers set password = '$encrypt' where id='$id'"); 
   if($quey){
       $rtn = array('success'=>'true','message'=>'Password Reset Successfull');
   }
   else{
       $rtn = array('success'=>'false','message'=>'Password Reset Successfull');
   }
}
echo json_encode($rtn);
?>