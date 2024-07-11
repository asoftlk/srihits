<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
$orderid = $_POST['orderid'];
$title = $_POST['title'];
$videoid = $_POST['videoid'];
$userid = $_POST['userid'];
$query =  mysqli_query($con, "SELECT * FROM payment WHERE order_id = '$orderid'");
if($query && mysqli_num_rows($query)>0){
    $row =  mysqli_fetch_assoc($query);
    $paytime = new DateTime($row['datetime']);
    $currtime = new DateTime(date('Y-m-d H:i:s'));
    $diff = $paytime->diff($currtime); 
    if($diff->h < 22){
        if($row['status_code']==2){
            $amount = $row['payhere_amount'];
            $currency = $row['payhere_currency'];
            $time = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'))+(48*60*60));
            $ins =  mysqli_query($con, "INSERT INTO subscription (`userid`, `orderid`, `videoid`, `title`, `amount`, `currency`) VALUES ('$userid', '$orderid', '$videoid', '$title', '$amount', '$currency')");
            if($ins){
                $rtn =  array('success'=>true, 'message'=>$title.' subscription is successful and valid upto '.$time);
            }
            else{
                $rtn =  array('success'=>false, 'message'=>'Payment successful, subscription failed contact support');
            }
        }
        elseif($row['status_code']==0){
            $rtn =  array('success'=>false, 'message'=>'Payment is pending');
        }
        elseif($row['status_code']==-1){
            $rtn =  array('success'=>false, 'message'=>'Payment was cancelled');
        }
        elseif($row['status_code']==-2){
            $rtn =  array('success'=>false, 'message'=>'Payment failed');
        }
        elseif($row['status_code']==-3){
            $rtn =  array('success'=>false, 'message'=>'Payment charged back');
        }
    }
    else{
        $rtn =  array('success'=>false, 'message'=>'Invalid Order details');
    }
    
}
else{
   $rtn =  array('success'=>false, 'message'=>'Invalid Order details'); 
}
echo json_encode($rtn);
?>