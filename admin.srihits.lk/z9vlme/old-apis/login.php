<?php
session_start();
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
date_default_timezone_set("Asia/Kolkata");
$datetime = date('d-m-Y H:i:s');
if(isset($_POST['loginSubmit'])){
$email = mysqli_real_escape_string($con, $_POST['user']);
$password = mysqli_real_escape_string($con, $_POST['pwd']);
$deviceinfo = mysqli_real_escape_string($con, $_POST['info']);
}
else{
$email = $obj['email'];
$password = $obj['password'];
$deviceinfo = $obj['info'];   
}
$que = "select * from appusers where email='$email' or mobilenumber = '$email'";
$query = mysqli_query($con,"select * from appusers where email='$email' or mobilenumber = '$email'");
$queryPass = mysqli_fetch_assoc($query);
$decrypt = password_verify($password,$queryPass['password']);
if($decrypt){
    $id = $queryPass['id'];
    $quer = mysqli_query($con,"select * from device where userid ='$id' ");
    $co = mysqli_num_rows($quer);
    if($co>5){
       $rtn = array('success'=>'false','message'=>'Exceeded out of limit');
    }
    else{
        $qury = mysqli_query($con,"select * from device where userid ='$id' and deviceinfo like '%$deviceinfo%'");
        $cuy = mysqli_num_rows($qury);
        if($cuy>0){
            $_SESSION['userid']=$id;
            $rtn = array('success'=>'true','message'=>'Login successfull','userid'=>$id,'name'=>$queryPass['name'],'log'=>$email); 
        }
        else{
          $query = "insert into device (userid,deviceinfo,lastlogin) values ('$id','$deviceinfo','$datetime')";
        $ca = mysqli_query($con,$query);
        if($ca){
           $rtn = array('success'=>'true','message'=>'Login successfull','userid'=>$id,'name'=>$queryPass['name'],'log'=>$email); 
        }
        else{
          $rtn = array('query'=>$query, 'success'=>'false','message'=>'Try again');  
        }   
        }
        
    }
    
}
else{$rtn = array('success'=>'false','message'=>'Invalid credentials');}

echo json_encode($rtn);
?>