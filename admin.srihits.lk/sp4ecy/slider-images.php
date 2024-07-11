<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$datetime = $_POST['datetime'];
$userid = $_POST['userid'];
$createdby = $_POST['createdby'];
$category=$_POST['category'];
$mediaID = $_POST['mediaId'];
$kid=$_POST['kid'];
for($i=0;$i<count($_FILES);$i++){
    $tp = $_FILES['image'.($i+1)]['name'];
    $tExt = pathinfo($tp, PATHINFO_EXTENSION);
    $newname=generateRandomString().".".$tExt;
	 $target_dir = "uploadedfiles/".$newname;
	 $url_Link = "https://srihits.veramasait.com/Admin/uploadedfiles/".$newname;
	 if (move_uploaded_file($_FILES['image'.($i+1)]["tmp_name"], $target_dir)) {
	     $query = "insert into sliderimages (displayname,name,url,datetime,userid,createdby,videoid,category,kid)values('$tp','$target_dir','$url_Link','$datetime','$userid','$createdby','$mediaID','$category','$kid')";
	     $chk = mysqli_query($con,$query);
	 }
}
if($chk){
	         $rtn = array('success'=>'true','message'=>'File uploaded Successful');
	     }
	     else{$rtn = array('success'=>'false','message'=>'File uploaded Failed');}
	     echo json_encode($rtn);
//--------------------------------------------------------------------------------
	  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString; }
?>