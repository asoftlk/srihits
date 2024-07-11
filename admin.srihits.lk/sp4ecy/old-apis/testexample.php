<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$datetime = $_POST['datetime'];
$unqid = $_POST['videoid'];
$ln = $_POST['slanguages'];
$gfh = $_POST['sco'];
$abc = explode(',',$ln,$gfh);
for($i=0;$i<$gfh;$i++){
    	$subt = $_FILES["subtitle".($i+1)]["name"];
$ext3 = pathinfo($_FILES["subtitle".($i+1)]["name"], PATHINFO_EXTENSION);
	$newname=generateRandomString().".".$ext3;
	 $target_dir = "subtitles/".$newname;
	 $url_Link = "https://srihits.veramasait.com/Admin/subtitles/".$newname;
	 if (move_uploaded_file($_FILES["subtitle".($i+1)]["tmp_name"], $target_dir)) {
	     $tp = $abc[$i];
	     $query = "insert into subtitles (videoid,language,displayname,name,url,datetime)values('$unqid','$tp','$subt','$target_dir','$url_Link','$datetime')";
	     $chk = mysqli_query($con,$query);
	     if($chk){}
	     else{}
	 }
}
$rtn = array('data'=>$subt,'ada'=>count($gfh));
echo json_encode($rtn);
?>