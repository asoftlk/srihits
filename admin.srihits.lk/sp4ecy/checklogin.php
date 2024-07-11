<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
date_default_timezone_set("Asia/Calcutta");
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$email = $obj['email'];
$password = $obj['password'];
$current = date("Y-m-d H:i:s");
$query = mysqli_query($con,"select * from user where email='$email'");
$queryPass = mysqli_fetch_assoc($query);
$decrypt = password_verify($password,$queryPass['password']);
if($decrypt){
    $date=$queryPass['datetime'];$subscription=$queryPass['subscription'];
   
   $end=date('Y-m-d H:i:s', strtotime($date. ' +'.$subscription.' days'));
   $first = strtotime($current);$second=strtotime($end);
   if($second>$first){
        $logindetails = array('userid'=>$queryPass['id'],'role'=>$queryPass['role'],'name'=>$queryPass['name'],'email'=>$queryPass['email'],'createdby'=>$queryPass['createdby'],
    'status'=>$queryPass['access'],'subscription'=>$queryPass['subscription']);
    $rtn = array('success'=>'true','message'=>'Login success','details'=>$logindetails);
   }
   else{
      $rtn = array('success'=>'false','message'=>'Please subscribe to continue','status'=>1); 
   }
}
else{
    $rtn = array('success'=>'false','message'=>'Invalid Credentials','status'=>0);
}
echo json_encode($rtn);
?>