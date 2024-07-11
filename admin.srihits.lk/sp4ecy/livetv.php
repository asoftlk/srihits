<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
$action = $_POST['action'];
if($action=='list'){
    $userid=$_POST['userid'];
    $createdby = $_POST['createdby'];
    $sql = $con->query("select url,logo,name,id from livetv where userid = '$userid' or createdby = '$createdby'");
    $list = [];
    $list = $sql->fetch_all(MYSQLI_ASSOC);
    $rtn = array('status'=>0,'data'=>$list);
}
elseif($action=='delete'){
    $id = $_POST['id'];
    $sqlDel = $con->query("delete from livetv where id ='$id'");
    if($sqlDel){$rtn = array('status'=>0,'message'=>'Deleted Successfully');}
    else{$rtn = array('status'=>1,'message'=>'Failed please try again');}
}
elseif($action=='create'){
    $userid=$_POST['userid'];
    $createdby = $_POST['createdby'];
    $name = $_POST['name'];
    $url = $_POST['url'];
    $logo = $_FILES["logo"]["name"];
    $ext3 = pathinfo($logo, PATHINFO_EXTENSION);
	$newname=generateRandomString().".".$ext3;
	$target_dir = "logo/livetv/".$newname;
	$url_Link = "https://srihits.veramasait.com/Admin/".$target_dir;
	 if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_dir)) {
    	$sqli = $con->query("insert into livetv (userid,createdby,url,logo,name) values ('$userid','$createdby','$url','$url_Link','$name')");
	    if($sqli){$rtn=array('status'=>0,'message'=>'Live added successfully');}
	    else{$rtn = array('status'=>1,'message'=>'Failed try again');}
	     
	 }
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