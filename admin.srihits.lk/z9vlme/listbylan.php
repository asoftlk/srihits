<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
$lan = $_POST['lan'];
$kids =$_POST['kids'];
$limit = "20";
$offset = $_POST['offset'];
$cal = $limit * ($offset-1);
$thumbnail=array();
$poster=array();
$query1 = mysqli_query($con,"select DISTINCT videoid, title, genre from moviedetails  where  languages like '%$lan%' and publish='1' and approve='1' and kids='$kids' order by id DESC limit $cal, $limit");
$tot = mysqli_num_rows($query1);
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
$rtn = array('count'=>$tot,'thumbnail'=>$thumbnail,'poster'=>$poster);
echo json_encode($rtn);
?>