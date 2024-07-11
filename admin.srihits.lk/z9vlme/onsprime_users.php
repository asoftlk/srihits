<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
date_default_timezone_set("Asia/Kolkata");
$datetime = date('d-m-Y H:i:s');
$email = $obj['email'];
$name = $obj['name'];
$deviceinfo = $obj['device'];
$type = $obj['type'];
$image = $obj['image'];
$query = mysqli_query($con,"select * from onsprimeusers where email='$email'");
$count = mysqli_num_rows($query);
$queryPass = mysqli_fetch_assoc($query);
if($count>0){
    $id = $queryPass['id'];
      $quer = mysqli_query($con,"select * from onsdevice where userid ='$id' ");
    $co = mysqli_num_rows($quer);
    if($co>5){
       $rtn = array('success'=>'false','message'=>'Exceeded out of limit');
    }
    else{
        $qury = mysqli_query($con,"select * from onsdevice where userid ='$id' and deviceinfo like '%$deviceinfo%'");
        $cuy = mysqli_num_rows($qury);
        if($cuy>0){
            $updatequery = mysqli_query($con,"update onsprimeusers set name='$name',email='$email',image='$image',logtime='$datetime',logintype='$type' where userid ='$id'");
            $rtn = array('success'=>'true','message'=>'Login successfull','userid'=>$id,'name'=>$name,'log'=>$email); 
        }
        else{
          $query = "insert into onsdevice (userid,deviceinfo,lastlogin) values ('$id','$deviceinfo','$datetime')";
        $ca = mysqli_query($con,$query);
        if($ca){
           $rtn = array('success'=>'true','message'=>'Login successfull','userid'=>$id,'name'=>$queryPass['name'],'log'=>$email); 
        }
        else{
          $rtn = array('success'=>'false','message'=>'Try again');  
        }   
        }
        
    } 
    
}
else{
 $queryins ="insert into onsprimeusers (name,email,image,logtime,logintype) values ('$name','$email','$image','$datetime','$type')";
  $check = mysqli_query($con,$queryins);
  $id= mysqli_insertid($con);
  if($check){ 
      $querydyc = mysqli_query($con,"insert into onsdevice (userid,deviceinfo,lastlogin) values ('$id','$deviceinfo','$datetime')");
      $rtn = array('success'=>'true','message'=>'Login successfull','userid'=>$id,'name'=>$name,'log'=>$email);}
  else{ $rtn = array('success'=>'false','message'=>'Try again'); }
}

echo json_encode($rtn);
?>