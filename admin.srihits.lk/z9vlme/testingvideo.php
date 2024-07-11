<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$type=$obj['type'];
$vid=$obj['id'];
$kids = $obj['kids'];
$userid = $obj['userid'];
if($type=='list'){
    $query = mysqli_query($con,"select thumbnail.*,moviedetails.title from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' ");
    $thumbnail=array();
    $poster=array();
    while($row=mysqli_fetch_assoc($query)){
        if($row['type']=='thumbnail'){
            
            array_push($thumbnail,$row);
        }
        else{array_push($poster,$row);}
        }
$rtn = array('thumbnail'=>$thumbnail,'poster'=>$poster);
}
else{
    $query = mysqli_query($con,"select thumbnail.*,vsc.title from thumbnail LEFT JOIN vsc ON vsc.videoid=thumbnail.videoid where vsc.publish='1' and vsc.videoid !='$vid' and vsc.approve='1' and vsc.kids='$kids' and vsc.type='$cate'");

    $thumbnail=array();
    $poster=array();
    $queryin = mysqli_query($con,"select * from vsc where videoid ='$vid'");
    $tmpAllW=mysqli_fetch_assoc($queryin);
    $caCrw = $tmpAllW['castcrew'];
    $direc = $tmpAllW['directors'];
    $tempCrew = explode('|',$caCrw);
    $tmpDir=explode('|',$direc);
    for($i=0;$i<count($tempCrew);$i++){
        $cjn=trim($tempCrew[$i]," ");
      $query = mysqli_query($con,"select thumbnail.*,vsc.title from thumbnail LEFT JOIN vsc ON vsc.videoid=thumbnail.videoid where vsc.publish='1'and vsc.approve='1' and vsc.videoid !='$vid' and vsc.kids='$kids' and vsc.type='$cate' and castcrew like '%$cjn%'");
    while($row=mysqli_fetch_assoc($query)){
        if($row['type']=='thumbnail'){
            array_push($thumbnail,$row);
        }
        else{array_push($poster,$row);}
        }  
    }
      for($i=0;$i<count($tmpDir);$i++){
        $cjn=trim($tmpDir[$i]," ");
      $query = mysqli_query($con,"select thumbnail.*,vsc.title from thumbnail LEFT JOIN vsc ON vsc.videoid=thumbnail.videoid where vsc.publish='1'and vsc.approve='1' and vsc.videoid !='$vid' and vsc.kids='$kids' and vsc.type='$cate' and directors like '%$cjn%'");
    while($row=mysqli_fetch_assoc($query)){
        if($row['type']=='thumbnail'){
            array_push($thumbnail,$row);
        }
        else{array_push($poster,$row);}
        }  
    }
     $reldata = array('thumbnail'=>$thumbnail,'poster'=>$poster);
    $query1 = mysqli_query($con,"select * from moviedetails INNER JOIN thumbnail ON moviedetails.videoid ='$vid' and thumbnail.videoid='$vid' and thumbnail.type='poster'");
    $details = array();
    while($row=mysqli_fetch_assoc($query1)){array_push($details,$row);}
    $query = mysqli_query($con,"select * from videos where videoid ='$vid'");
    $video=array();
    while($row=mysqli_fetch_assoc($query)){
            array_push($video,$row);
        }
    $qury = mysqli_query($con,"select * from wishlist where videoid='$vid' and userid = '$userid'");
    $cdf = mysqli_num_rows($qury);
    // $fav='';
    if($cdf>0){
        $fav='1';}
    else{$fav='0';}
    $yur = mysqli_query($con,"select * from playtime where videoid='$vid' and userid = '$userid'");
    $ads = mysqli_num_rows($yur);
    $oin = mysqli_fetch_assoc($yur);
    //  $duration='';
    if($ads>0){$duration=$oin['duration'];}
    else{$duration='0';}
    $detailsby = array('details'=>$details,'media'=>$video,'relateddata'=>$reldata,'favourite'=>$fav,'duration'=>$duration);
$rtn = array('data'=>$detailsby);
}
echo json_encode($rtn);
?>