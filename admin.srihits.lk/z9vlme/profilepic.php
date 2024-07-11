<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
mysqli_set_charset($con,"utf8mb4");
// header('Access-Control-Allow-Origin: *');

 $video = $_FILES["image"]["tmp_name"];
 $userid = $_POST['userid'];
 $ext3 = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
 $newname=generateRandomString().".".$ext3;
 $output = 'profileimages/'.$newname;
 if(move_uploaded_file($_FILES['image']['tmp_name'],$output)){
     $url = "https://srihits.veramasait.com/App/$output";
     $query = "update appusers set image='$url' where id='$userid' ";
     $chk = mysqli_query($con,$query);
         if($chk){
             $rtn = array('success'=>'true','message'=>'image Uploaded');
         }
         else{$rtn = array('success'=>'false','message'=>'image not Uploaded');}
    }else{$rtn=array('success'=>'false','message'=>'image not Uploaded');}
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