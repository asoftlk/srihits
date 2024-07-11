<?php
$myfiles = scandir("uploadedfiles/videos/");
$files=[];
for($i=2; $i<count($myfiles);$i++){
    if($myfiles[$i] != '.ftpquota')
    array_push($files, $myfiles[$i]);
}
echo json_encode(array('success'=>true, 'data'=>$files));
?>