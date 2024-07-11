<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://cloud.websms.lk/smsAPI?sendsms=null&apikey=cOpDat7cbjjThVUrL3BylWGPLskvmlyU&apitoken=rrl91673248290&type=sms&from=SOMARATNE%20D&to=9032841549&text=Your%20OTP%20is%20123456%20for%20Srihits.%20Please%20use%20it%20to%20login%20to%20Srithits%20OTT%20platform.%20Thank%20you!&route=0',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: PHPSESSID=263676860be42796d97a5a8a2772d646'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?>