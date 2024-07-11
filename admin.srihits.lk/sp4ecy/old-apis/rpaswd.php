<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$email = $obj['email'];
$password = $obj['password'];

    $encrypt = password_hash($password, PASSWORD_BCRYPT);
    $query = mysqli_query($con,"select * from user where email='$email'");
    $count = mysqli_num_rows($query);
    if($count>0){
        $query = mysqli_query($con,"update user set password='$encrypt' where email='$email'");
        if($query){$rtn = array('success'=>'true','message'=>'Password changed successfull');}
        else{$rtn = array('success'=>'false','message'=>'Password not changed');}
        
    }
    else{
    $rtn = array('success'=>'false','message'=>'Email Not Exists','abc'=>$query);
    }   

echo json_encode($rtn);
?>