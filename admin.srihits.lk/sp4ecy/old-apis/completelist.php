<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$createdby=$obj['createdby'];
$userid=$obj['userid'];
$role = $obj['role'];
$queryL=mysqli_query($con,"select * from languages");
$languages = array();
while($row=mysqli_fetch_assoc($queryL))
{
    array_push($languages,$row);
}
$queryC=mysqli_query($con,"select * from countries");
$countriestotal=mysqli_num_rows($queryC);
$countries = array();
while($row=mysqli_fetch_assoc($queryC))
{
    array_push($countries,$row);
}
if($role=='Admin'){$queryMV=mysqli_query($con,"select * from videos where type='movie'");}
else{$queryMV=mysqli_query($con,"select * from videos where type='movie'and userid='$userid'");}
$moviestotal=mysqli_num_rows($queryMV);
if($role=='Admin'){$queryTS=mysqli_query($con,"select * from videos where type='tv'");}
else{$queryTS=mysqli_query($con,"select * from videos where type='tv'and userid='$userid'");}
$tvseriestotal=mysqli_num_rows($queryTS);
if($role=='Admin'){$queryUS=mysqli_query($con,"select * from user where createdby='$userid'");}
else{$queryUS=mysqli_query($con,"select * from user where createdby='$userid'");}
$userstotal=mysqli_num_rows($queryUS);
$totalcounts = array('movie'=>$moviestotal,'tvseries'=>$tvseriestotal,'livetv'=>0,'users'=>$userstotal,'genre'=>0,'countries'=>$countriestotal,);
$cClist=[];
$getCC = mysqli_query($con,"select * from cast_crew where userid='$userid'");
if(mysqli_num_rows($getCC)>0){
    $cClist=$getCC->fetch_all(MYSQLI_ASSOC);
}
$rtn = array('languages'=>$languages,'countries'=>$countries,'dashboard'=>$totalcounts,'castcrew'=>$cClist);
echo json_encode($rtn);
?>