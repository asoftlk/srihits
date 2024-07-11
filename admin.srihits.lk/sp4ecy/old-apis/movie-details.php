<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$title=$_POST['title'];
$slug=$_POST['slug'];
$cacr=mysqli_real_escape_string($con,$_POST['castcrew']);
$director = mysqli_real_escape_string($con,$_POST['directors']);
$writer = mysqli_real_escape_string($con,$_POST['writers']);
$languages = $_POST['languages'];
$price = $_POST['price'];
$rating = $_POST['rating'];
$releDat = $_POST['releasedate'];
$country = $_POST['countries'];
$genre = mysqli_real_escape_string($con,$_POST['genres']);
$runtime = $_POST['runtime'];
$approve = $_POST['approve'];
$type = $_POST['type'];
$trailerid = $_POST['trailerid'];
$userid = $_POST['userid'];
$shortdescrip = mysqli_real_escape_string($con,$_POST['shortdescrip']);
$desc = mysqli_real_escape_string($con,$_POST['description']);
$subs = $_POST['subscriber'];
$kid = $_POST['kids'];
$publish = $_POST['publish'];
$notif = $_POST['notification'];
$datetime = $_POST['datetime'];
$unqid = $_POST['videoid'];
$ln = $_POST['slanguages'];
$tl=$_POST['thlnk'];
$pl=$_POST['pstlnk'];

//--------------------------------------------------------------------------------
if($tl=='1'){
    $turl = $_POST['lnk'];
    $tExt = pathinfo($turl, PATHINFO_EXTENSION);
    if($tExt==''){$tExt='jpg';}
    $newname=generateRandomString().".".$tExt;
	 $target_dir = "uploadedfiles/images/".$newname;
	 $url_Link = $urlpath."uploadedfiles/images/".$newname;
	 $tp = 'thumbnail';
	 $tQry = mysqli_query($con,"select * from thumbnail where videoid='$unqid' and type='$tp'");
	 $row = mysqli_num_rows($tQry);
	 if($row>0){
	    	 file_put_contents($target_dir, file_get_contents($turl));
	        $query="update thumbnail set displayname='$thumbnail',name='$target_dir',url='$url_Link',datetime='$datetime' where videoid='$unqid' and type='$tp'";
	        $chk = mysqli_query($con,$query);
	        if($chk){}
	         else{} 
	 }
	 else{
	     file_put_contents($target_dir, file_get_contents($turl));
	     $query = "insert into thumbnail (videoid,type,displayname,name,url,datetime)values('$unqid','$tp','$thumbnail','$target_dir','$url_Link','$datetime')";
	     $chk = mysqli_query($con,$query);
	     if($chk){}
	     else{}
	 }
}
else{
$thumbnail = $_FILES["thumbnail"]["name"];
$ext3 = pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION);
	$newname=generateRandomString().".".$ext3;
	 $target_dir = "uploadedfiles/images/".$newname;
	 $url_Link = $urlpath."uploadedfiles/".$newname;
	 $tp = 'thumbnail';
	 $tQry = mysqli_query($con,"select * from thumbnail where videoid='$unqid' and type='$tp'");
	 $row = mysqli_num_rows($tQry);
	 if($row>0){
    	    if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_dir)) {
    	     $query="update thumbnail set displayname='$thumbnail',name='$target_dir',url='$url_Link',datetime='$datetime' where videoid='$unqid' and type='$tp'";
    	     $chk = mysqli_query($con,$query);
    	     if($chk){}
    	     else{}
    	 }  
	 }
	 else{
	        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_dir)) {
    	     $query = "insert into thumbnail (videoid,type,displayname,name,url,datetime)values('$unqid','$tp','$thumbnail','$target_dir','$url_Link','$datetime')";
    	     $chk = mysqli_query($con,$query);
    	     if($chk){}
    	     else{}
    	    }
	 }
}
//----------------------------------------poster----------------------------------------
if($pl=='1'){
    $purl = $_POST['lnkp'];
    $tExt = pathinfo($turl, PATHINFO_EXTENSION);
    if($tExt==''){$tExt='jpg';}
    $newname=generateRandomString().".".$tExt;
	 $target_dir = "uploadedfiles/images/".$newname;
	 $url_Link = $urlpath."uploadedfiles/".$newname;
	 $tp = 'poster';
	 $tQry = mysqli_query($con,"select * from thumbnail where videoid='$unqid' and type='$tp'");
	 $row = mysqli_num_rows($tQry);
	 if($row>0){
	     	 file_put_contents($target_dir, file_get_contents($purl));
	        $query="update thumbnail set displayname='$poster',name='$target_dir',url='$url_Link',datetime='$datetime' where videoid='$unqid' and type='$tp'";
	     $chk = mysqli_query($con,$query);
	     if($chk){}
	     else{}
	 }
	 else{
	     	 file_put_contents($target_dir, file_get_contents($purl));
	      $query = "insert into thumbnail (videoid,type,displayname,name,url,datetime)values('$unqid','$tp','$poster','$target_dir','$url_Link','$datetime')";
	     $chk = mysqli_query($con,$query);
	     if($chk){}
	     else{}
	 }
}
else{
	 $poster = $_FILES["poster"]["name"];
    $ext3 = pathinfo($_FILES["poster"]["name"], PATHINFO_EXTENSION);
	$newname=generateRandomString().".".$ext3;
	 $target_dir = "uploadedfiles/images/".$newname;
	 $url_Link = $urlpath."/uploadedfiles/images/".$newname;
	 $tp = 'poster';
	 $tQry = mysqli_query($con,"select * from thumbnail where videoid='$unqid' and type='$tp'");
	 $row = mysqli_num_rows($tQry);
	 if($row>0){
	     	 if (move_uploaded_file($_FILES["poster"]["tmp_name"], $target_dir)) {
	        $query="update thumbnail set displayname='$poster',name='$target_dir',url='$url_Link',datetime='$datetime' where videoid='$unqid' and type='$tp'";
	     $chk = mysqli_query($con,$query);
	     if($chk){}
	     else{}
	 }
	 }
	 else{
	     	 if (move_uploaded_file($_FILES["poster"]["tmp_name"], $target_dir)) {
	      $query = "insert into thumbnail (videoid,type,displayname,name,url,datetime)values('$unqid','$tp','$poster','$target_dir','$url_Link','$datetime')";
	     $chk = mysqli_query($con,$query);
	     if($chk){}
	     else{}
	 }
	 }
}
//--------------------------------------------------------------------------------
$gfh = $_POST['sco'];
$abc = explode(',',$ln,$gfh);
for($i=0;$i<$gfh;$i++){
    	$subt = $_FILES["subtitle".($i+1)]["name"];
    	if($subt!=''){
$ext3 = pathinfo($_FILES["subtitle".($i+1)]["name"], PATHINFO_EXTENSION);
	$newname=generateRandomString().".".$ext3;
	 $target_dir = "subtitles/".$newname;
	 $url_Link = $urlpath."subtitles/".$newname;
	 if (move_uploaded_file($_FILES["subtitle".($i+1)]["tmp_name"], $target_dir)) {
	     $tp = $abc[$i];
	     $query = "insert into subtitles (videoid,language,displayname,name,url,datetime)values('$unqid','$tp','$subt','$target_dir','$url_Link','$datetime')";
	     $chk = mysqli_query($con,$query);
	     if($chk){}
	     else{}
	 }
    	}
}
$ci =$_POST['stcount'];
$si=$_POST['stl'];
$loi = $_POST['lll'];
$abc = explode(',',$si,$ci);
$cde = explode(',',$loi,$ci);

for($i=0;$i<count($abc);$i++){
     $purl = $abc[$i];
     if($purl!=''){
    $tExt = pathinfo($turl, PATHINFO_EXTENSION);
    if($tExt==''){$tExt='txt';}
    $newname=generateRandomString().".".$tExt;
	 $target_dir = "subtitles/".$newname;
	 $url_Link = $urlpath."subtitles/".$newname;
	 file_put_contents($target_dir, file_get_contents($purl));
	  $tp = $cde[$i];
	     $query = "insert into subtitles (videoid,language,displayname,name,url,datetime)values('$unqid','$tp','$subt','$target_dir','$url_Link','$datetime')";
	     $chk = mysqli_query($con,$query);
	     if($chk){}
	     else{}
     }
}
//--------------------------------------------------------------------------------
$hj=mysqli_query($con,"select * from moviedetails where videoid='$unqid'");
$row = mysqli_num_rows($hj);
if($row>0){
    $query="update moviedetails set title='$title',slug='$slug',shortdescription='$shortdescrip',description='$desc',castcrew='$cacr',directors='$director',writers='$writer',languages='$languages',imdbrating='$rating',releasedate='$releDat',
    countries='$country',genre='$genre',runtime='$runtime',kids='$kid',sendemail='$subs',pushnotification='$notif',publish='$publish',insertdatetime='$datetime',approve='$approve',price='$price',trailerid='$trailerid' where videoid='$unqid'";
    $chk = mysqli_query($con,$query);
if($chk){$rtn=array('success'=>'true','message'=>'Movie Details updated Successfull');}
else{$rtn=array('success'=>'fail','message'=>'Movie Details Not updated');}
}
else{
$query = "insert into moviedetails (userid,videoid,title,slug,shortdescription,description,castcrew,directors,writers,languages,imdbrating,releasedate,countries,genre,runtime,kids,sendemail,pushnotification,publish,insertdatetime,approve,price,trailerid) values
('$userid','$unqid','$title','$slug','$shortdescrip','$desc','$cacr','$director','$writer','$languages','$rating','$releDat','$country','$genre','$runtime','$kid','$subs','$notif','$publish','$datetime','$approve','$price','$trailerid')";
$chk = mysqli_query($con,$query);
if($chk){$rtn=array('success'=>'true','message'=>'Movie Details added Successfull');}
else{$rtn=array('success'=>'fail','message'=>'Movie Details Not added');}
}

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