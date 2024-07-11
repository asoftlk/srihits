<?php
$order_id = $_POST['orderid'];
$amount = $_POST['amount'];
$merchant_id = 1221934;
$currency =$_POST['currency'];
$merchant_secret = "NDI2MTczMzA5MzIwMDUwMDYwODgzNTkzMzM5NDgyNDI0NTYwMjM3OQ==";//"MzUyNzQ5Nzc2NjEwMjQ4MzYwNzYzOTgwOTE4ODA1MjMxOTQ3OTMwMw==";
if($order_id!='' && $amount!=''){
    $hash = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        number_format($amount, 2, '.', '') . 
        $currency .  
        strtoupper(md5($merchant_secret)) 
    ) 
);
echo $hash;
}
else
echo 1;
?>