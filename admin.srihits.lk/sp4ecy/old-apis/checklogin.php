<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$email = $obj['email'];
$password = $obj['password'];
$query = mysqli_query($con,"select * from user where email='$email'");
print_r($query);
$queryPass = mysqli_fetch_assoc($query);
$decrypt = password_verify($password,$queryPass['password']);
if($decrypt){
    $logindetails = array('userid'=>$queryPass['id'],'role'=>$queryPass['role'],'name'=>$queryPass['name'],'email'=>$queryPass['email'],'createdby'=>$queryPass['createdby'],
    'status'=>$queryPass['access'],'subscription'=>$queryPass['subscription']);
    $rtn = array('success'=>'true','message'=>'Login success','details'=>$logindetails);
}
else{
    $rtn = array('success'=>'false','message'=>'Invalid credentials');
}
echo json_encode($rtn);
?>