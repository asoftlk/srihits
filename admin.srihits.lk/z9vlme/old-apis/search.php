<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
if(!empty($obj)){
$query=$obj['name'];
$kids = $obj['kids'];
}
else{
    $query=$_POST['name'];
    $data = $query;
    $kids =$_POST['kids'];
}
$thumbnail=array();
$poster=array();
$query2 = mysqli_query($con,"select DISTINCT videoid, title, genre from tvseriesdetails  where title like '%$query%' or castcrew like '%$query%'or  languages like '%$query%'or  genre like '%$query%'or directors like '%$query%'or writers like '%$query%'and publish='1' and approve='1' and kids='$kids'");
$query1 = mysqli_query($con,"select DISTINCT videoid, title, genre from moviedetails  where title like '%$query%' or castcrew like '%$query%' or directors like '%$query%'or writers like '%$query%'or languages like '%$query%'or genre like '%$query%'and publish='1' and approve='1' and kids='$kids'");
$query3 =mysqli_query($con, "select DISTINCT videoid, title, genre, type from vsc  where title like '%$query%'  or castcrew like '%$query%'or genre like '%$query%' or directors like '%$query%'or writers like '%$query%'and publish='1' and approve='1' and kids='$kids'");
while($row=mysqli_fetch_assoc($query1)){
    $tmpid=$row['videoid'];
    $query = mysqli_query($con,"select * from thumbnail where videoid='$tmpid'");
    while($row1=mysqli_fetch_assoc($query)){
        $row1['status']='0';
        $row1['title'] = $row['title'];
        $row1['genre'] = str_replace(" |", ",", $row['genre']);
         if($row1['type']=='thumbnail'){
            array_push($thumbnail,$row1);
        }
        else{array_push($poster,$row1);}
    }
}
// $query2 = mysqli_query($con,"select DISTINCT videoid from tvseriesdetails  where title like '%$query%' or castcrew like '%$query%'or  languages like '%$query%'or  genre like '%$query%'or directors like '%$query%'or writers like '%$query%'and publish='1' and approve='1' and kids='$kids'");
while($row=mysqli_fetch_assoc($query2)){
    $tmpid=$row['videoid'];
    $query = mysqli_query($con,"select * from thumbnail where videoid='$tmpid'");
    while($row1=mysqli_fetch_assoc($query)){
        $row1['status']='1';
        $row1['title'] = $row['title'];
        $row1['genre'] = str_replace(" |", ",", $row['genre']);
         if($row1['type']=='thumbnail'){
            array_push($thumbnail,$row1);
        }
        else{array_push($poster,$row1);}
    }
}
// $query3 =mysqli_query($con, "select DISTINCT videoid,type from vsc  where title like '%$query%'  or castcrew like '%$query%'or genre like '%$query%' or directors like '%$query%'or writers like '%$query%'and publish='1' and approve='1' and kids='$kids'");
while($row=mysqli_fetch_assoc($query3)){
    $tmpid=$row['videoid'];
    $query = mysqli_query($con,"select * from thumbnail where videoid='$tmpid'");
    while($row1=mysqli_fetch_assoc($query)){
        $row1['status']='2';
        $row1['action']=$row['type'];
        $row1['title'] = $row['title'];
        $row1['genre'] = str_replace(" |", ",", $row['genre']);
         if($row1['type']=='thumbnail'){
            array_push($thumbnail,$row1);
        }
        else{array_push($poster,$row1);}
    }
}

$rtn = array('thumbnail'=>$thumbnail,'poster'=>$poster);
echo json_encode($rtn);
?>