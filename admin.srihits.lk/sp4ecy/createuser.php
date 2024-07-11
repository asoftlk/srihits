<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$role = $obj['role'];
$email = $obj['email'];
$name = $obj['name'];
$password = $obj['password'];
$access = $obj['access'];
$datetime = $obj['datetime'];
$createdby=$obj['createdby'];
$subcribe=$obj['period'];
$type = $obj['type'];
$limit = $obj['limit'];
$offset = $obj['offset'];
$cal = $limit * ($offset-1);
$srch=$obj['query'];
if($type=='add'){
     $encrypt = password_hash($password, PASSWORD_BCRYPT);
    $query = mysqli_query($con,"select * from user where email='$email'");
    $count = mysqli_num_rows($query);
    if($count>0){
        $rtn = array('success'=>'false','message'=>'Email Already Exists');
    }
    else{
    $query = "insert into user(role,email,password,access,datetime,name,createdby,subscription)values('$role','$email','$encrypt','$access','$datetime','$name','$createdby','$subcribe')";
    $chk=mysqli_query($con,$query);
    if($chk){$rtn = array('success'=>'true','message'=>'User Registered Successfull');}
    else{$rtn = array('success'=>'false','message'=>'User Registered Failed');}
    }   
}
else if($type=='list'){
   
    $query = mysqli_query($con,"select SQL_CALC_FOUND_ROWS id,role,email,access,name,subscription from user where createdby='$createdby' limit $cal, $limit");
    $total = mysqli_query($con,"SELECT FOUND_ROWS() as count");
$tot = mysqli_fetch_assoc($total);
    $list=array();
    while($row=mysqli_fetch_assoc($query)){
       $tempDate =  date_add($date,date_interval_create_from_date_string("40 days"));
        array_push($list,$row);}
    $rtn = array('success'=>'true','clientlist'=>$list,'count'=>(int)$tot['count']);
}
else if($type=='search'){
    $avb="select SQL_CALC_FOUND_ROWS id,role,email,access,name,subscription from user where createdby = '$createdby' and name like '%$srch%' or role like '%$srch%' limit $cal, $limit";
    $query = mysqli_query($con,$avb);
     $total = mysqli_query($con,"SELECT FOUND_ROWS() as count");
$tot = mysqli_fetch_assoc($total);
    $list=array();
    while($row=mysqli_fetch_assoc($query)){array_push($list,$row);}
    $rtn = array('success'=>'true','clientlist'=>$list,'count'=>(int)$tot['count'],'da'=>$query);
    
}

echo json_encode($rtn);
?>