<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
$userid = $_POST['userid'];
$name = $_POST['name'];
$id = $_POST['castcrewid'];
if($id==''){
  $image = $_FILES["image"]["tmp_name"];
$ext3 = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
 $newname=generateRandomString().".".$ext3;
 $output = 'cast-crew/'.$newname;
 if(move_uploaded_file($_FILES['image']['tmp_name'],$output)){
     $url=$urlpath.$output;
     $query = "insert into cast_crew (userid,name,url)values('$userid','$name','$url')";
     $chk = mysqli_query($con,$query);
         if($chk){
             $rtn = array('success'=>true,'message'=>'Cast/Crew created successfully');
         }
         else{$rtn = array('success'=>false,'message'=>'Cast/Crew not created');}
    }else{$rtn=array('success'=>false,'message'=>'image not Uploaded');}  
}
else{
    if(is_uploaded_file($_FILES["image"]["tmp_name"])){
          $image = $_FILES["image"]["tmp_name"];
         $ext3 = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
         $newname=generateRandomString().".".$ext3;
        $output = 'cast-crew/'.$newname;
        if(move_uploaded_file($_FILES['image']['tmp_name'],$output)){
         $url=$urlpath.$output;
         $upquery = mysqli_query($con,"update cast_crew set url='$url' where id='$id'");
        if($upquery){$rtn = array('success'=>true,'message'=>'Cast/Crew updated successfully');}
        else{$rtn = array('success'=>false,'message'=>'Cast/Crew not updated');}
    }else{$rtn=array('success'=>false,'message'=>'image not Uploaded');}
    }
        $upquery = mysqli_query($con,"update cast_crew set name='$name' where id='$id'");
        if($upquery){$rtn = array('success'=>true,'message'=>'Cast/Crew updated successfully');}
        else{$rtn = array('success'=>false,'message'=>'Cast/Crew not updated');}
}
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