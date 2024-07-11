<?php
$dirPath = generateRandomString();
// $the_mode = "0755";
// $the_path = "/home/veramasait/srihits_veramasait_com/App/".$dirPath;
// // mkdir($the_path,"0755");
// chmod($the_path, 0755);
function generateRandomString($length = 11) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString; }
    print_r($dirPath);
?>
