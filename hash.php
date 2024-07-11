<?php
$order_id = $_POST['orderid'];
$amount = $_POST['amount'];
$merchant_id = 1221934;
$currency =$_POST['currency'];
$merchant_secret = "MjcwNzQxODczMzMwNTY0MTk3NTY0MTg5NjA1NTM1MjEwNDQ0MjcwMQ==";//"MzUyNzQ5Nzc2NjEwMjQ4MzYwNzYzOTgwOTE4ODA1MjMxOTQ3OTMwMw==";
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