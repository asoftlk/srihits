<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
mysqli_set_charset($con,"utf8mb4");
// header('Access-Control-Allow-Origin: *');
$query = mysqli_query($con,"select * from videos where status='3'");
$chk = mysqli_num_rows($query);
if($chk>0){
    $rtn = array('success'=>'false','message'=>'Watermark processing');
}
else{
    $query = mysqli_query($con,"select * from videos where status='4'"); 
    $chk2 = mysqli_num_rows($query);
    if($chk2>0){
        $todo = mysqli_fetch_assoc($query);
   $id = $todo['id'];
   $the_path = $rootpath;
   $imgpath=$the_path.'logo/srihits.png';
   $logoOutput = $the_path.'watermarkfiles/'.$todo['name'];
   $inputpath = $the_path.$todo['uploadedpath'];
   $query = mysqli_query($con,"update videos set status='3',log='watermark adding' where id = $id");
//   $command = "/usr/bin/ffmpeg -y -i $inputpath -i $imgpath -filter_complex 'overlay = main_w-(overlay_w+10):10' $logoOutput";
      exec ("sh /home/srihits/public_html/admin.srihits.lk/sp4ecy/addlogo.sh $inputpath $imgpath $logoOutput",$output1,$retval);
    //  system($command,$return_value);
     if($retval==0){
         unlink($inputpath);
         $input2 = 'watermarkfiles/'.$todo['name'];
         $query = mysqli_query($con,"update videos set status='2',pathwv='$input2',log='watermark added' where id = $id");
         $rtn = array('success'=>'true','message'=>'Watermark added');
     }
     else{
         $query = mysqli_query($con,"update videos set status='4',log='$retval' where id = $id");
         $rtn=array('success'=>'false','message'=>'Watermark not added','chk'=>$retval);} 
    }
  else{
         $rtn = array('success'=>'false','message'=>'No files to convert');
  }
     
 echo json_encode($rtn);
}
 
     
 function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString; }
?>