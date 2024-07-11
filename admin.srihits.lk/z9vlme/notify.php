<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
header('Access-Control-Allow-Origin: *');

echo $merchant_id         = $_POST['merchant_id'];
$order_id            = $_POST['order_id'];
$payhere_amount      = $_POST['payhere_amount'];
$payhere_currency    = $_POST['payhere_currency'];
echo $status_code         = $_POST['status_code'];
$md5sig              = $_POST['md5sig'];

$merchant_secret = 'NDI2MTczMzA5MzIwMDUwMDYwODgzNTkzMzM5NDgyNDI0NTYwMjM3OQ==';

$local_md5sig = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        $payhere_amount . 
        $payhere_currency . 
        $status_code . 
        strtoupper(md5($merchant_secret)) 
    ) 
);

 $ins="insert into payment (merchant_id,order_id,payhere_amount,payhere_currency,status_code,md5sig,datetime) values 
('$merchant_id', '$order_id', '$payhere_amount','$payhere_currency','$status_code','$md5sig',now())";
$isq=mysqli_query($con,$ins);
	
if (($local_md5sig === $md5sig) AND ($status_code == 2) ){
    // $up = mysqli_query($con, "update temp_cart set status_code='$status_code' WHERE Rpayorderid='$order_id'");
        //TODO: Update your database as payment success
}

?>
