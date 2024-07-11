<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
$action = $_POST['action'];
if($action=='list'){
$query = mysqli_query($con, "SELECT * from livetv");
$livechannels=[];
$count = mysqli_num_rows($query);
while($row=mysqli_fetch_assoc($query)){
    array_push($livechannels, $row);
}
$rtn = array('data'=>$livechannels,'count'=>$count);
}
elseif($action=="listbyid"){
    $id = $_POST['id'];
    $query = mysqli_query($con, "SELECT * from livetv where id = '$id'");
    $list=[];
    $row=mysqli_fetch_assoc($query);
    array_push($list, $row);
    $rtn=array('list'=>$row);
}
echo json_encode($rtn);
?>