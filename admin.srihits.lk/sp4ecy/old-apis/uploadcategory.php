<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$userid = $obj['userid'];
$createdby = $obj['createdby'];
$datetime = date("Y-m-d H:i:s");
$category = $obj['category'];
$type=$obj['type'];
if($type=='add'){
$query = mysqli_query($con,"select * from uploadcategory where category='$category'");
$cvb = mysqli_num_rows($query);
    if($cvb>0){
      $rtn=array('success'=>'false','message'=>'Category already exists');
    }
    else{
      $iQ = "insert into uploadcategory(createdby,userid,category,datetime)values('$createdby','$userid','$category','$datetime')";
    $chk=mysqli_query($con,$iQ);
    if($chk){$rtn=array('success'=>'true','message'=>'Category added Successfully',);}
    else{$rtn=array('success'=>'false','message'=>'Category added Failed');}
    }
}
else if($type=='list'){
    $qry =mysqli_query($con,"select category from uploadcategory");
    $list=array();
    while($row=mysqli_fetch_assoc($qry)){array_push($list,$row['category']);}
    $rtn=array('success'=>'true','list'=>$list);
}
echo json_encode($rtn);
?>