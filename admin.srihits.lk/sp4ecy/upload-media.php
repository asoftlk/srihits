<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
mysqli_set_charset($con,"utf8mb4");
// header('Access-Control-Allow-Origin: *');
$mid = $_POST['mID'];
// $size = $_POST['size'];
// $video = $_FILES["video"]["tmp_name"];
 $name = mysqli_real_escape_string($con,$_POST["name"]);
 $userid = $_POST['userid'];
 $createdby = $_POST['createdby'];
 $datetime=$_POST['datetime'];
 $type = $_POST['type'];
 $category = $_POST['category'];
 $new_catgry = str_replace(' ', '', $category);
 $new_str = str_replace(' ', '', $name);
 if(str_replace(' ', '_', $_POST['videoname']) == ''){
     echo json_encode(array('success'=>'false','message'=>'Video cannot be empty'));
     exit();
 }
 $newname = str_replace(' ', '_', $_POST['videoname']);
 $output = 'uploadedfiles/videos/'.$_POST['videoname'];
 $size = filesize($output);
 $qcheck =  mysqli_query($con, "SELECT * FROM videos WHERE uploadedpath = '$output'");
 if($qcheck && mysqli_num_rows($qcheck)>0){
    $rtn = array('success'=>'false','message'=>'This file has already been added');
    echo json_encode($rtn); exit();
 }
//  $ext3 = pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION);
//  $newname=generateRandomString().".".$ext3;
//  $output = 'uploadedfiles/videos/'.$newname;
//  if(move_uploaded_file($_FILES['video']['tmp_name'],$output)){
     $query = "insert into videos (videoid,displayname,name,size, datetime,type,userid,createdby,category,uploadedpath,status)values('$mid','$name','$newname','$size','$datetime','$type','$userid','$createdby','$new_catgry','$output','4')";
     $chk = mysqli_query($con,$query);
         if($chk){
             $rtn = array('success'=>'true','message'=>'Video Added');
         }
         else{$rtn = array('success'=>'false','message'=>'Video not Uploaded');}
    // }else{$rtn=array('success'=>'false','message'=>'Video not Uploaded');}
 echo json_encode($rtn);
 function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString; }
?>