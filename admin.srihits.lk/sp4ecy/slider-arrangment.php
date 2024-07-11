<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$json = file_get_contents("php://input") ;
$obj = json_decode($json,true);
$data = $obj['sD'];
for($i=0;$i<count($data);$i++){
    $a=$data[$i]['id'];
    $b=$data[$i]['state'];
 $query = "update sliderimages set arrange='$b' where id='$a'";
 $chk = mysqli_query($con,$query);
}
 if($chk){$rtn=array('success'=>'true','message'=>' Changes Saved Successfull');}
 else{$rtn=array('success'=>'fail','message'=>'Changes not saved');}
echo json_encode($rtn);
?>