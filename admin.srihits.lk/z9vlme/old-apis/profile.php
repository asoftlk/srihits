<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
if(isset($_POST['id'])){
$id = mysqli_real_escape_string($con,$_POST['id']);
}
else{
$id = $obj['id'];    
}
$query = mysqli_query($con,"select device.*,appusers.image from appusers LEFT JOIN device ON appusers.id=device.userid where appusers.id='$id'");
$lst = array();
while($row = mysqli_fetch_assoc($query)){
    if($row['lastlogin']=='0000-00-00 00:00:00'){
        $row['logintime']='';$row['date']='';
    }
    else{
      $row['logintime']= get_time_ago(strtotime($row['lastlogin']));
    $row['date']=date("d F Y", strtotime($row['lastlogin']));  
    }
    array_push($lst,$row);}
$query = mysqli_query($con,"select name, email, mobilenumber, image from appusers  where id='$id'");
$dta = array();
while($row=mysqli_fetch_assoc($query)){
    $img = $row['image'];
    array_push($dta,$row);}
$rtn = array('success'=>'true','image'=>$img,'data'=>$lst, 'user'=>$dta);
echo json_encode($rtn);

function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return   $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}
?>