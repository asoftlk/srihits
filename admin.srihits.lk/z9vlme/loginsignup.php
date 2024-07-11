<?php
session_start();
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
// header("Content-Type: application/json");
// $json = file_get_contents('php://input');
// $obj = json_decode($json,true);
date_default_timezone_set("Asia/Kolkata");
$datetime = date('d-m-Y H:i:s');
// if(isset($_POST['loginsign'])){
$contact = mysqli_real_escape_string($con, $_POST['contact']);
$otp = mysqli_real_escape_string($con, $_POST['otp']);
$id = mysqli_real_escape_string($con, $_POST['id']);
$mobileCode = explode(",",mysqli_real_escape_string($con, $_POST['mobileCode']));
$ctry_code = $mobileCode[0];
$country = $mobileCode[1];
$deviceinfo = mysqli_real_escape_string($con, $_POST['info']);
// }
// echo $que = "select * from appusers where email='$contact' or mobilenumber = '$contact'";
$timeExp = date('Y-m-d H:i:s');
$otpcheck =  mysqli_query($con, "SELECT * FROM otpbucket WHERE id='$id' and datetime > '$timeExp'");
if($otpcheck && mysqli_num_rows($otpcheck)>0){
    $otpdata =  mysqli_fetch_assoc($otpcheck);
    if(filter_var($contact, FILTER_VALIDATE_EMAIL)){
        if($otpdata['email']==$contact && $otpdata['otp']==$otp){
            $query = mysqli_query($con,"select * from appusers where email='$contact' and status = '0'");
            if($query && mysqli_num_rows($query)>0){
                $row =  mysqli_fetch_assoc($query);
                checkDevices($row['id'], $con, $deviceinfo);
            }
            else{
                // echo "INSERT INTO appusers (country_code, email, country) VALUES ('$ctry_code', '$contact', '$country'";
                $query =  mysqli_query($con, "INSERT INTO appusers (country_code, email, country) VALUES ('$ctry_code', '$contact', '$country')");
                if($query){
                    $lastid = mysqli_insert_id($con);
                    checkDevices($lastid, $con, $deviceinfo);
                }
                else{
                    $rtn = array('success'=>'false','message'=>'Login  Failed');
                }
            }
        }
        else{
            $rtn = array('success'=>'false','message'=>'Invalid  OTP');
            echo json_encode($rtn);
        }
    }
    elseif($otpdata['mobile']==$contact && $otpdata['otp']==$otp){
        $query = mysqli_query($con,"select * from appusers where mobile='$contact' and status = '0'");
        print_r($query);
        if($query && mysqli_num_rows($query)>0){
            $row =  mysqli_fetch_assoc($query);
            checkDevices($row['id'], $con, $deviceinfo);
        }
        else{
            // echo "INSERT INTO appusers (country_code, mobilenumber, country) VALUES ('$ctry_code', '$contact', '$country')";
            $query =  mysqli_query($con, "INSERT INTO appusers (country_code, mobilenumber, country) VALUES ('$ctry_code', '$contact', '$country')");
            if($query){
                $lastid = mysqli_insert_id($con);
                checkDevices($lastid, $con, $deviceinfo);
            }
            else{
                $rtn = array('success'=>'false','message'=>'Login  Failed');
            }
        }
    }
    else{
        $rtn = array('success'=>'false','message'=>'Invalid  OTP');
        echo json_encode($rtn);
    }
}
else{
    $rtn = array('success'=>'false','message'=>'OTP Expired');
}
function checkDevices($id, $con, $deviceinfo){
    $quer = mysqli_query($con,"select * from device where userid ='$id'");
    $co = mysqli_num_rows($quer);
    if($co>5){
       $rtn = array('success'=>'false','message'=>'Exceeded Number of login');
    }
    else{
        $qury = mysqli_query($con,"select * from device where userid ='$id' and deviceinfo like '%$deviceinfo%'");
        $cuy = mysqli_num_rows($qury);
        if($cuy>0){
            $_SESSION['userid']=$id;
            $rtn = array('success'=>'true','message'=>'Login successfull','userid'=>$id); 
        }
        else{
            $query = "insert into device (userid,deviceinfo,lastlogin) values ('$id','$deviceinfo','$datetime')";
            $ca = mysqli_query($con,$query);
            if($ca){
               $rtn = array('success'=>'true','message'=>'Login successfull','userid'=>$id); 
            }
            else{
              $rtn = array('success'=>'false','message'=>'Try again');  
            }   
        }
        
    }
    echo json_encode($rtn);
}


?>
