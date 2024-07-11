<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
if(isset($_POST['signupSubmit'])){
$obj = json_decode($json,true);
$name = mysqli_real_escape_string($con, $_POST['userName']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$mobile = mysqli_real_escape_string($con, $_POST['mobile']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$otp = mysqli_real_escape_string($con, $_POST['otp']);
$id = mysqli_real_escape_string($con, $_POST['id']);
$country = mysqli_real_escape_string($con, $_POST['country']);
$encrypt = password_hash($password, PASSWORD_BCRYPT);
}
else{
$obj = json_decode($json,true);
$name = $obj['name'];
$email = $obj['email'];
$mobile = $obj['mobile'];
$password = $obj['password'];
$encrypt = password_hash($password, PASSWORD_BCRYPT);
}

$query = mysqli_query($con,"select * from appusers where email = '$email' and mobilenumber='$mobile'");
$ca = mysqli_num_rows($query);
if($ca>0){
    $rtn = array('success'=>'false','message'=>'Already Registered Sign in');
}
else{
    $query = "insert into appusers (name,mobilenumber,email,password) values ('$name','$mobile','$email','$encrypt')";
    $ch = mysqli_query($con,$query);
    if($ch){
        $rtn = array('success'=>'true','message'=>'Registered Successfully');
    }
    else{$rtn = array('success'=>'fail','message'=>'Registeration failed');}
}
echo json_encode($rtn);
?>