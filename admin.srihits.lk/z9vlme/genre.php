<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$kids = $obj['kids'];

$list = array();
$query = mysqli_query($con,"select genre from  moviedetails where publish='1' and approve='1' and kids='0'");

while($row = mysqli_fetch_assoc($query)){
    $string = $row['genre'];
    $str_arr = explode ("|", $string);
    for($i=0;$i<count($str_arr);$i++){
        $str = trim($str_arr[$i]);
        if(in_array($str,$list))
        {}
        else{
            array_push($list,$str); 
        }
    }
}
$query = mysqli_query($con,"select genre from  tvseriesdetails where publish='1' and approve='1' and kids='0'");

while($row = mysqli_fetch_assoc($query)){
    $string = $row['genre'];
    $str_arr = explode ("|", $string);
    for($i=0;$i<count($str_arr);$i++){
        $str = trim($str_arr[$i]);
        if(in_array($str,$list))
        {}
        else{
            array_push($list,$str); 
        }
    }
}

$quc = mysqli_query($con,"select name from countries");
$clist = array();
while($row = mysqli_fetch_assoc($quc)){array_push($clist,$row['name']);}
$rtn = array('genre'=>$list,'countries'=>$clist);
echo json_encode($rtn);
?>