<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
if(!empty($obj)){
$query=$obj['name'];
$kids = $obj['kids'];
$userid = $obj['userid'];
}
else{
    $query=$_POST['name'];
    $data = $query;
    $kids =$_POST['kids'];
    $userid = $_POST['userid'];
}
$conCurr =  mysqli_query($con, "SELECT appusers.country, country_currency.currency, country_currency.exchange from appusers INNER JOIN country_currency ON appusers.country = country_currency.code WHERE appusers.id = '$userid'");
$conCurrCount =  mysqli_num_rows($conCurr);
if($conCurrCount>0){
    $conrow = mysqli_fetch_assoc($conCurr);
    $currency = $conrow['currency'];
    
    if($conrow['currency'] == 'LKR' || $conrow['currency'] =='USD' || $conrow['currency'] =='GBP' || $conrow['currency'] =='EUR' || $conrow['currency'] =='AUD')
        $currency = $conrow['currency'];
    else $currency = 'USD';
    
    if($conrow['currency'] == 'LKR') $exchange = 1;
    elseif($conrow['currency'] =='USD' || $conrow['currency'] =='GBP' || $conrow['currency'] =='EUR' || $conrow['currency'] =='AUD')
    $exchange = $conrow['exchange'];
    else $exchange=1;
}
else{
    $exchange = 1;
    $currency='LKR';
}
$thumbnail=array();
$poster=array();
$query2 = mysqli_query($con,"select DISTINCT videoid, title, genre, price, usd_price from tvseriesdetails  where title like '%$query%' or castcrew like '%$query%'or  languages like '%$query%'or  genre like '%$query%'or directors like '%$query%'or writers like '%$query%'and publish='1' and approve='1' and kids='$kids'");
$query1 = mysqli_query($con,"select DISTINCT videoid, title, genre, price, usd_price from moviedetails  where title like '%$query%' or castcrew like '%$query%' or directors like '%$query%'or writers like '%$query%'or languages like '%$query%'or genre like '%$query%'and publish='1' and approve='1' and kids='$kids'");
$query3 =mysqli_query($con, "select DISTINCT videoid, title, genre, price, type from vsc  where title like '%$query%'  or castcrew like '%$query%'or genre like '%$query%' or directors like '%$query%'or writers like '%$query%'and publish='1' and approve='1' and kids='$kids'");
while($row=mysqli_fetch_assoc($query1)){
    $tmpid=$row['videoid'];
    $query = mysqli_query($con,"select * from thumbnail where videoid='$tmpid'");
    while($row1=mysqli_fetch_assoc($query)){
        $row1['status']='0';
        $row1['title'] = $row['title'];
        if($currency=='LKR')$row1['price'] = $row['price'];
        else $row1['price'] = $row['usd_price']*$exchange;
        $row1['currency'] = $currency;
        $row1['genre'] = str_replace(" |", ",", $row['genre']);
         if($row1['type']=='thumbnail'){
            array_push($thumbnail,$row1);
        }
        else{array_push($poster,$row1);}
    }
}
// $query2 = mysqli_query($con,"select DISTINCT videoid from tvseriesdetails  where title like '%$query%' or castcrew like '%$query%'or  languages like '%$query%'or  genre like '%$query%'or directors like '%$query%'or writers like '%$query%'and publish='1' and approve='1' and kids='$kids'");
while($row=mysqli_fetch_assoc($query2)){
    $tmpid=$row['videoid'];
    $query = mysqli_query($con,"select * from thumbnail where videoid='$tmpid'");
    while($row1=mysqli_fetch_assoc($query)){
        $row1['status']='1';
        $row1['title'] = $row['title'];
        if($currency=='LKR')$row1['price'] = $row['price'];
        else $row1['price'] = $row['usd_price']*$exchange;
        $row1['currency'] = $currency;
        $row1['genre'] = str_replace(" |", ",", $row['genre']);
         if($row1['type']=='thumbnail'){
            array_push($thumbnail,$row1);
        }
        else{array_push($poster,$row1);}
    }
}
// $query3 =mysqli_query($con, "select DISTINCT videoid,type from vsc  where title like '%$query%'  or castcrew like '%$query%'or genre like '%$query%' or directors like '%$query%'or writers like '%$query%'and publish='1' and approve='1' and kids='$kids'");
while($row=mysqli_fetch_assoc($query3)){
    $tmpid=$row['videoid'];
    $query = mysqli_query($con,"select * from thumbnail where videoid='$tmpid'");
    while($row1=mysqli_fetch_assoc($query)){
        $row1['status']='2';
        $row1['action']=$row['type'];
        $row1['title'] = $row['title'];
        if($currency=='LKR')$row1['price'] = $row['price'];
        else $row1['price'] = $row['usd_price']*$exchange;
        $row1['currency'] = $currency;
        $row1['genre'] = str_replace(" |", ",", $row['genre']);
         if($row1['type']=='thumbnail'){
            array_push($thumbnail,$row1);
        }
        else{array_push($poster,$row1);}
    }
}

$rtn = array('thumbnail'=>$thumbnail,'poster'=>$poster);
echo json_encode($rtn);
?>