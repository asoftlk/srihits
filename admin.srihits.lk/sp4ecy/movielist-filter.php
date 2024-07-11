<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
// header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$limit = $obj['limit'];
$offset = $obj['offset'];
$cal = $limit * ($offset-1);
$query = $obj['query'];
$userid = $obj['userid'];
$role = $obj['role'];
if($role=='Admin'){
$query1 = "select SQL_CALC_FOUND_ROWS  * from moviedetails  where moviedetails.title like '%$query%' or moviedetails.slug like '%$query%' or moviedetails.castcrew like '%$query%' or moviedetails.directors like '%$query%'or moviedetails.writers like '%$query%'or moviedetails.languages like '%$query%'or moviedetails.countries like '%$query%'or moviedetails.genre like '%$query%' order by id DESC limit $cal, $limit";}
else if($role=='Manager'){
    $query1 = "select SQL_CALC_FOUND_ROWS  * from moviedetails  where (moviedetails.title like '%$query%' or moviedetails.slug like '%$query%' or moviedetails.castcrew like '%$query%' or moviedetails.directors like '%$query%'or moviedetails.writers like '%$query%'or moviedetails.languages like '%$query%'or moviedetails.countries like '%$query%'or moviedetails.genre like '%$query%') and (moviedetails.userid ='$userid'or moviedetails.createdby='$userid')  order by id DESC limit $cal, $limit";
}
else{
    $query1 = "select SQL_CALC_FOUND_ROWS  * from moviedetails  where (moviedetails.title like '%$query%' or moviedetails.slug like '%$query%' or moviedetails.castcrew like '%$query%' or moviedetails.directors like '%$query%'or moviedetails.writers like '%$query%'or moviedetails.languages like '%$query%'or moviedetails.countries like '%$query%'or moviedetails.genre like '%$query%') and moviedetails.userid ='$userid' order by id DESC limit $cal, $limit";
}
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
$rtn = array('count'=>(int)$tot['count'],'movielist'=>$list);
echo json_encode($rtn);
?>