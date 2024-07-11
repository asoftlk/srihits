<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
$query = mysqli_query($con,"select * from videos where status='1'");
$chk = mysqli_num_rows($query);
if($chk>0){
    $rtn = array('success'=>'false','message'=>'video conversion processing');
}
else{
   $query = mysqli_query($con,"select * from videos where status='2'"); 
   $chk2 = mysqli_num_rows($query);
   if($chk2>0){
         $todo = mysqli_fetch_assoc($query);
   $id = $todo['id'];
   $dC=generateRandomString();
   $dc2=$rootpath."j8n2Grm17yM/".$dC;
  if(!is_dir($dc2)){
      $result = mkdir($dc2);
      $dirPath = 'j8n2Grm17yM/'.$dC;
  }
  else{
      $i=0;
      while($i<20){
        $dC=generateRandomString();
          $dc2=$rootpath."j8n2Grm17yM/".$dC;
          if(!is_dir($dc2)){
              $result = mkdir($dc2);
              $dirPath = 'j8n2Grm17yM/'.$dC;
              break;
          }
      }
  }
    $path=$urlpath.$dirPath.'/';
    $inputpath=$rootpath.$todo['pathwv'];
    $nameV=generateRandomString();
    $query = mysqli_query($con,"update videos set status='1',log='video converting' where id = $id");
    exec ("sh /home/srihits/public_html/admin.srihits.lk/sp4ecy/create-vod-hls.sh $inputpath $dc2 $nameV $path",$output1,$retval); 
    if($retval==0){
        // unlink($inputpath);
        $finalurl = $path.$nameV.'.m3u8';
        $nameFial = $dirPath.'/'.$nameV.'.m3u8';
        $query = mysqli_query($con,"update videos set status='0',url = '$finalurl',name='$nameFial',log='video converted' where id = $id");
    }
    else{
       $query = mysqli_query($con,"update videos set status='5',log='video conversion error team will check' where id = $id"); 
       $rtn=array('a'=>$dc2,'b'=>$nameV,'c'=>$output1);
    }
   }
 else{
    $rtn = array('success'=>'false','message'=>'No video to convert'); 
 }

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