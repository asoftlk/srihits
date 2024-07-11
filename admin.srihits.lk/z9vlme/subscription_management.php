<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
date_default_timezone_set("Asia/Kolkata");
$time1= date("Y-m-d H:i:s");
    $query = mysqli_query($con,"select * from movie_subcription");
    while($row=mysqli_fetch_assoc($query)){
        $time=$row['datatime'];
        $rid=$row['id'];
        $hourdiff = round((strtotime($time1) - strtotime($time))/3600*60, 1);
        if($hourdiff>'2880'){
            $qry = mysqli_query($con,"update movie_subcription set status = '0' where id='$rid'");
            if($qry){
                
            }
        }
    }
?>