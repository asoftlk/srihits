<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
mysqli_set_charset($con,"utf8mb4");
// header('Access-Control-Allow-Origin: *');
$mid = generateRandomString();
$size = $_FILES["video"]["size"];
$video = $_FILES["video"]["tmp_name"];
 $name = mysqli_real_escape_string($con,$_POST["name"]);
 $userid = $_POST['userid'];
 $createdby = $_POST['createdby'];
 date_default_timezone_set('Asia/Kolkata');
 $datetime=date("Y-m-d H:i:s");
 $type = $_POST['type'];
 $category = $_POST['category'];
 $new_catgry = str_replace(' ', '', $category);
 $new_str = str_replace(' ', '', $name);
 $ext3 = pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION);
 $newname=generateRandomString().".".$ext3;
 $output = 'uploadedfiles/videos/'.$newname;
 if(move_uploaded_file($_FILES['video']['tmp_name'],$output)){
     $query = "insert into videos (videoid,displayname,name,size,datetime,type,userid,createdby,category,uploadedpath,status)values
     ('$mid','$name','$newname','$size','$datetime','$type','$userid','$createdby','$new_catgry','$output','4')";
     $chk = mysqli_query($con,$query);
         if($chk){
             $rtn = array('success'=>'true','message'=>'Video Uploaded');
         }
         else{$rtn = array('success'=>'false','message'=>'Video not Uploaded');}
    }else{$rtn=array('success'=>'false','message'=>'Video not Uploaded');}
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