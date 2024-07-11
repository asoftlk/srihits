<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// $json = file_get_contents('countrycodes.json');
// $data = json_decode($json);
// for($i=0; $i<(count($data)); $i++){
//     $name =  mysqli_real_escape_string($con, $data[$i]->name);
//     $dcode = $data[$i]->dial_code;
//     $code = $data[$i]->code;
//     $currency = $data[$i]->currency;
//     mysqli_query($con, "INSERT INTO country_currency (name, dial_code, code, currency) VALUES ('$name', '$dcode', '$code', '$currency')");
// }

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://openexchangerates.org/api/latest.json?app_id=544dbec25d314628aef1840d61289ff6',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
$responselist =  json_decode($response);

foreach($responselist->rates as $key=>$value){
    // echo $key.":".$value."<br>";
    $value = number_format((float)$value, 2, '.', '');
    $date = date('Y-m-d H:i:s');
    $query =  mysqli_query($con, "UPDATE `country_currency` SET `exchange`='$value', `datetime` = '$date' WHERE `currency`='$key'");
}
?>

