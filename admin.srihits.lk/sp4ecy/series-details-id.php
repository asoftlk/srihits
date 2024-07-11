<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
// header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$vId = $obj['id'];
$details = array();
$query = mysqli_query($con,"select * from tvseriesdetails where videoid='$vId'");
while($row=mysqli_fetch_assoc($query)){
    $temp = $row['userid'];
    $tid = $row['trailerid'];
    $dom=mysqli_query($con,"select name from user where id='$temp'");
    $r1 =mysqli_fetch_assoc($dom);
    $row['createdname']=$r1['name'];
    $trler = mysqli_query($con,"select displayname,url from videos where videoid='$tid'");
    $r2=mysqli_fetch_assoc($trler);
    $row['trailername']=$r2['displayname'];
    $row['trailerurl']=$r2['url'];
    array_push($details,$row);}
$thm=array();
$qry = mysqli_query($con,"select * from thumbnail where videoid='$vId'");
while($row=mysqli_fetch_assoc($qry)){array_push($thm,$row);}
$sut = array();
$qrs = mysqli_query($con,"select * from subtitles where videoid='$vId'");
while($row=mysqli_fetch_assoc($qrs)){array_push($sut,$row);}
$mov = array();
$qmv = mysqli_query($con,"select displayname,url from videos where videoid='$vId'");
while($row=mysqli_fetch_assoc($qmv)){array_push($mov,$row);}
$rtn=array('details'=>$details,'thumbnails'=>$thm,'subtitles'=>$sut,'movie'=>$mov);
$finl = array('list'=>$rtn);
echo json_encode($finl);
?>