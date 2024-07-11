<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$name = $obj['name'];
$shortname = $obj['shortname'];
$countryid = $obj['countryid'];
$type = $obj['type'];
if($type=='add'){
    $query = mysqli_query($con,"select * from countries where name='$name'");
    $tot = mysqli_num_rows($query);
    if($tot==0){
        $query1 = "insert into countries(name,shortname)values('$name','$shortname')";
        $chk=mysqli_query($con,$query1);
        if($chk){
             $rtn = array('success'=>'true','message'=>'Country Added Successfully');
        }
        else{
             $rtn = array('success'=>'fail','message'=>'Failed Try again');
        }
    }
    else{
        $rtn = array('success'=>'fail','message'=>'Country Already Added');
    }
}
else if($type=='edit'){
    $queryU = "update countries set name='$name', shortname='$shortname' where id='$countryid'";
    $chk=mysqli_query($con,$queryU);
    if($chk){ $rtn = array('success'=>'true','message'=>'Country Updated Successfully');}
    else{ $rtn = array('success'=>'fail','message'=>'Country updated failed');}
}
else if($type=='delete'){
    $queryD="delete from countries where id='$countryid'";
    $chk = mysqli_query($con,$queryD);
    if($chk){ $rtn = array('success'=>'true','message'=>'Country deleted Successfully');}
    else{ $rtn = array('success'=>'fail','message'=>'Country deleted failed');}
}
echo json_encode($rtn);
?>