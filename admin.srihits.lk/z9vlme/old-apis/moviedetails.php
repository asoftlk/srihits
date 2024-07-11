<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
if(isset($_POST['type'])){
$type=mysqli_real_escape_string($con, $_POST['type']);
$vid=mysqli_real_escape_string($con, $_POST['id']);
$kids = mysqli_real_escape_string($con, $_POST['kids']);
$userid = mysqli_real_escape_string($con, $_POST['userid']);
}
else{
$type=$obj['type'];
$vid=$obj['id'];
$kids = $obj['kids'];
$userid = $obj['userid'];
}
if($type=='list'){
    $query = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' ");
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
     $thumbnail=array();
    $poster=array();
    $queryin = mysqli_query($con,"select * from moviedetails where videoid ='$vid'");
    $tmpAllW=mysqli_fetch_assoc($queryin);
    $caCrw = $tmpAllW['castcrew'];
    $direc = $tmpAllW['directors'];
    $langu = $tmpAllW['languages'];
    $tempCrew = explode('|',$caCrw);
    $tmpDir=explode('|',$direc);
    $tmpLan=explode(',',$langu);
    for($i=0;$i<count($tempCrew);$i++){
           $cjn=trim($tempCrew[$i]," ");
      $query = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1'and moviedetails.approve='1' and moviedetails.videoid !='$vid' and moviedetails.kids='$kids' and castcrew like '%$cjn%'");
    while($row=mysqli_fetch_assoc($query)){
        if($row['type']=='thumbnail'){
            array_push($thumbnail,$row);
        }
        else{array_push($poster,$row);}
        }  
    }
    for($i=0;$i<count($tmpDir);$i++){
           $cjn=trim($tmpDir[$i]," ");
      $query = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1'and moviedetails.approve='1' and moviedetails.videoid !='$vid' and moviedetails.kids='$kids' and directors like '%$cjn%'");
    while($row=mysqli_fetch_assoc($query)){
        if($row['type']=='thumbnail'){
            array_push($thumbnail,$row);
        }
        else{array_push($poster,$row);}
        }  
    }
    for($i=0;$i<count($tmpLan);$i++){
           $cjn=trim($tmpLan[$i]," ");
      $query = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1'and moviedetails.approve='1' and moviedetails.videoid !='$vid' and moviedetails.kids='$kids' and languages like '%$cjn%'");
    while($row=mysqli_fetch_assoc($query)){
        if($row['type']=='thumbnail'){
            array_push($thumbnail,$row);
        }
        else{array_push($poster,$row);}
        }  
    }
     
    
     $reldata = array('thumbnail'=>$thumbnail,'poster'=>$poster);
    $query1 = mysqli_query($con,"select * from moviedetails where videoid ='$vid'");
    $details = array();
    $posThm=array();
    while($row=mysqli_fetch_assoc($query1)){
        $queryPT=mysqli_query($con,"select * from thumbnail  where videoid='$vid'");
        while($row1=mysqli_fetch_assoc($queryPT)){array_push($posThm,$row1);}
        $row['images']=$posThm;
        $triID=$row['trailerid'];
        if($triID==null){
           $row['trailer']=''; 
        }
        else{
            $queryTrai = mysqli_query($con,"select * from videos  where videoid='$triID'");
        $row['trailer']=mysqli_fetch_assoc($queryTrai); 
        }
       
        array_push($details,$row);}
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
    $lbyuQuery = mysqli_query($con,"select likecount,dislikecount from likebyuser where videoid='$vid' and userid='$userid'");
    $lbyCont = mysqli_num_rows($lbyuQuery);
    if($lbyCont>0){
        $temp = mysqli_fetch_assoc($lbyuQuery);
        $likeby=array('like'=>(int) $temp['likecount'],'dislike'=>(int) $temp['dislikecount']);}
    else{$likeby=0;}
    $detailsby = array('details'=>$details,'media'=>$video,'relateddata'=>$reldata,'favourite'=>$fav,'duration'=>$duration,'likes'=>$likeby);
$rtn = array('data'=>$detailsby);
}
echo json_encode($rtn);
?>