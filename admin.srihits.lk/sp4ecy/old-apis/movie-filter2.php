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
$userid = $obj['userid'];
$role = $obj['role'];
$title = $obj['name'];
$lang = $obj['language'];
$genre = $obj['genre'];
$director = $obj['director'];
$cast = $obj['cast'];
$date = $obj['date'];
$condt = $title == '' ? "" : " AND title='$title' ";
$condL = $lang == '' ? "" : " AND languages like '%$lang%' ";
$condG = $genre == '' ? "" : " AND genre like '%$genre%' ";
$condD = $director == '' ? "" : " AND directors like '%$director%' ";
$condC = $cast == '' ? "" : " AND castcrew like '%$cast%' ";
$condDt = $date == '' ? "" : " AND insertdatetime='$date' ";
$query = "select SQL_CALC_FOUND_ROWS  * from moviedetails where userid = '$userid' ".$condt." ".$condL." ".$condG." ".$condD." ".$condC." ".$condDt."  order by id DESC limit $cal, $limit";
$chk = mysqli_query($con,$query);
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