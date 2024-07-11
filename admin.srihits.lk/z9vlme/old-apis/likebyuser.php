<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$userid = $obj['userid'];
$videoid = $obj['videoid'];
$like = $obj['likeby'];
$dislike = $obj['dislikeby'];
$query = mysqli_query($con,"select * from likebyuser where videoid='$videoid' and userid='$userid'");
$cout = mysqli_num_rows($query);
if($cout>0){
   $upquery = mysqli_query($con,"update likebyuser set likecount='$like',dislikecount='$dislike' where videoid='$videoid' and userid='$userid'");
   if($upquery){
       $rtn = array('success'=>true,'message'=>'Successfully Updated');
   }
   else{
       $rtn = array('success'=>false,'message'=>'Failed to Update');
   }
}
else{
    $inquery = mysqli_query($con,"insert into likebyuser (videoid,userid,likecount,dislikecount) values('$videoid','$userid','$like','$dislike')");
    if($inquery){$rtn = array('success'=>true,'message'=>'Successfully Updated');}
    else{$rtn = array('success'=>true,'message'=>'Failed to Update');}
}
echo json_encode($rtn);
?>