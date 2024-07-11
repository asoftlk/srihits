<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$limit = $obj['limit'];
$offset = $obj['offset'];
$cal = $limit * ($offset-1);
$type = $obj['type'];
$query = $obj['query'];
$query1 = "select SQL_CALC_FOUND_ROWS  * from vsc  where title like '%$query%' or slug like '%$query%' or castcrew like '%$query%'or season like '%$query%'or languages like '%$query%'or countries like '%$query%'or genre like '%$query%' and vsc.type='$type' order by id DESC limit $cal, $limit";
$chk = mysqli_query($con,$query1);
$total = mysqli_query($con,"SELECT FOUND_ROWS() as count");
$tot = mysqli_fetch_assoc($total);
$list = array();
while($row=mysqli_fetch_assoc($chk))
{$id=$row['videoid'];
    $query2 = mysqli_query($con,"select * from thumbnail where type='thumbnail' and videoid='$id'");
    while($row1=mysqli_fetch_assoc($query2)){
        $row['type']=$row1['type'];
        $row['url']=$row1['url'];
    array_push($list,$row);}
}
$rtn = array('count'=>(int)$tot['count'],'vsclist'=>$list);
echo json_encode($rtn);
?>