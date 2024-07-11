<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$role = $obj['role'];
$type = $obj['type'];
$limit = $obj['limit'];
$offset = $obj['offset'];
$cal = $limit * ($offset-1);
$srch=$obj['query'];
if($type=='list'){
    $query = mysqli_query($con,"select SQL_CALC_FOUND_ROWS * from appusers  limit $cal, $limit");
    $total = mysqli_query($con,"SELECT FOUND_ROWS() as count");
$tot = mysqli_fetch_assoc($total);
    $list=array();
    while($row=mysqli_fetch_assoc($query)){
        $datetimeFromMysql=$row['datetime'];
    $time = strtotime($datetimeFromMysql);
    $row['datetime1'] = date("m/d/Y g:i A", $time);
    $temid=$row['id'];
    $querydev = mysqli_query($con,"select SQL_CALC_FOUND_ROWS * from device where userid= '$temid'");
    $devtot = mysqli_query($con,"SELECT FOUND_ROWS() as count");
    $row['devicecount']=mysqli_fetch_assoc($devtot)['count'];
    $devList=array();
    while($row8=mysqli_fetch_assoc($querydev)){array_push($devList,$row8);}
    $row['devicelist']=$devList;
        array_push($list,$row);}
    $rtn = array('success'=>'true','userlist'=>$list,'count'=>(int)$tot['count']);
}
else if($type=='search'){
    $avb="select SQL_CALC_FOUND_ROWS * from appusers where  name like '%$srch%' or mobilenumber like '%$srch%' limit $cal, $limit";
    $query = mysqli_query($con,$avb);
     $total = mysqli_query($con,"SELECT FOUND_ROWS() as count");
$tot = mysqli_fetch_assoc($total);
    $list=array();
    while($row=mysqli_fetch_assoc($query)){
          $datetimeFromMysql=$row['datetime'];
    $time = strtotime($datetimeFromMysql);
    $row['datetime1'] = date("m/d/Y g:i A", $time);
    $temid=$row['id'];
    $querydev = mysqli_query($con,"select SQL_CALC_FOUND_ROWS * from device where userid= '$temid'");
    $devtot = mysqli_query($con,"SELECT FOUND_ROWS() as count");
    $row['devicecount']=mysqli_fetch_assoc($devtot)['count'];
    $devList=array();
    while($row8=mysqli_fetch_assoc($querydev)){array_push($devList,$row8);}
    $row['devicelist']=$devList;
        array_push($list,$row);}
    $rtn = array('success'=>'true','userlist'=>$list,'count'=>(int)$tot['count'],'da'=>$query);
    
}

echo json_encode($rtn);
?>