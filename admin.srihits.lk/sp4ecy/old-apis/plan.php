<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$id=$obj['id'];
$price = $obj['price'];
$type=$obj['type'];
if($type=='list'){
    $query = mysqli_query($con,"select * from plan");
    $list = array();
    while($row=mysqli_fetch_assoc($query)){array_push($list,$row);}
    $rtn = array('success'=>'true','list'=>$list);
}
else if($type=='update'){
    $query = "update plan set amount=$price where id=$id";
    $chk = mysqli_query($con,$query);
    if($chk){
        $rtn = array('success'=>'true','message'=>'Price updated successfull');
    }
    else{
        $rtn = array('success'=>'false','message'=>'Price not updated');
    }
}
echo json_encode($rtn);

?>