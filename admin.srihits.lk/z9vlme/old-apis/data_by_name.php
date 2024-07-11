<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$name=$obj['name'];
$action=$obj['action'];
$status=$obj['status'];
$kids = $obj['kids'];
$cate = $obj['category'];
$userid = $obj['userid'];

$thumbnail=array();
$poster=array();
$condt="";
switch ($status) {
  case "0":
    $condt= " AND castcrew like '%$name%' ";
    break;
  case "1":
    $condt= " AND directors like '%$name%' ";
    break;
  case "2":
    $condt= " AND writers like '%$name%' ";
    break;
  case "3":
    $condt= " AND languages like '%$name%' ";
    break;
  default:
    $condt= " AND genre like '%$name%' ";
}

    if($action=='movie'){
        $rty="select thumbnail.*,moviedetails.title from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1'and moviedetails.approve='1' and moviedetails.kids='$kids' ".$condt."";
           $query = mysqli_query($con,$rty);
            while($row=mysqli_fetch_assoc($query)){
                if($row['type']=='thumbnail'){
                    array_push($thumbnail,$row);
                }
                else{array_push($poster,$row);}
                }  
    }
    elseif($action=='series'){
          $query = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title from thumbnail LEFT JOIN tvseriesdetails ON tvseriesdetails.videoid=thumbnail.videoid where tvseriesdetails.publish='1'and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' ".$condt."");
            while($row=mysqli_fetch_assoc($query)){
                if($row['type']=='thumbnail'){
                    array_push($thumbnail,$row);
                }
                else{array_push($poster,$row);}
                } 
    }
    elseif($action=='vsc'){
         $query = mysqli_query($con,"select thumbnail.*,vsc.title from thumbnail LEFT JOIN vsc ON vsc.videoid=thumbnail.videoid where vsc.publish='1'and vsc.approve='1' and vsc.kids='$kids' and vsc.type='$cate' ".$condt."");
            while($row=mysqli_fetch_assoc($query)){
                if($row['type']=='thumbnail'){
                    array_push($thumbnail,$row);
                }
                else{array_push($poster,$row);}
                }  
    }
    
    $rtn = array('success'=>'true','thumbnail'=>$thumbnail,'poster'=>$poster);
    echo json_encode($rtn);
   
?>