<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
$contact = $_POST['contact'];
$otp = generateRandomString();
// $message = 'Your One Time Password '.$otp;
$message ="Your OTP is $otp for Srihits. Please use it to login to Srihits OTT platform. Thank you!";
if(filter_var($contact, FILTER_VALIDATE_EMAIL)){
    $output='<p>Dear user,</p>';
	$output.='<p style="font-size:18px;">'.$message.'</p>';	
	$output.='<p>Thanks,</p>';
	$output.='<p>With Regards</p>';
	$output.='<p>Srihits</p>';
	$mail_body = $output; 
	$subject = "Verification - Application";
	$email_to = $contact;
	$fromserver = "noreply@srihits.lk"; 
	require("PHPMailer/PHPMailerAutoload.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = "mail.srihits.lk"; // Enter your host here
	$mail->SMTPAuth = true;
	$mail->Username = "noreply@srihits.lk"; // Enter your email here
	$mail->Password = "Sr!h!ts@lk"; //Enter your passwrod here
	$mail->Port = 25 ;
	$mail->IsHTML(true);
// 	$mail->SMTPDebug = true;
	$mail->From = "noreply@srihits.lk";
	$mail->FromName = "Srihits";
	$mail->Sender = $fromserver; // indicates ReturnPath header
	$mail->Subject = $subject;
	$mail->Body = $mail_body;
	$mail->AddAddress($email_to);
	if(!$mail->Send())
	{
	    $rtn = array('success'=>'fail', 'message'=>'Failed to send Email');
        echo json_encode($rtn); exit();
	}
	else
	{
	    $minutes_to_add=15;
        $time = new DateTime(date('Y-m-d H:i:s'));
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        $otpEndTime = $time->format('Y-m-d H:i:s');
        $sql = mysqli_query($con, "SELECT * FROM otpbucket WHERE email='$contact'");
        if($sql && mysqli_num_rows($sql)>0){
            $list = mysqli_fetch_assoc($sql);
            $id = $list['id'];
            // echo "UPDATE otpbucket set otp = '$otp' and datetime = '$otpEndTime' WHERE id = '$id'";
            $sqlu =  mysqli_query($con, "UPDATE otpbucket SET otp='$otp',datetime='$otpEndTime' WHERE id='$id'");
            if($sqlu){
                $rtn = array('success'=>'true', 'message'=>'OTP sent to '.$contact, 'id'=>$id);
                echo json_encode($rtn); exit();
            }
            else{
                $rtn = array('success'=>'fail', 'message'=>'OTP Update failed');
                echo json_encode($rtn); exit();
            }
        }
        else{
            $sqli = mysqli_query($con, "INSERT INTO otpbucket (email, otp, datetime) VALUES ('$contact', '$otp', '$otpEndTime')");
            if($sqli){
                $id = mysqli_insert_id($con);
                $rtn = array('success'=>'true', 'message'=>'OTP sent to '.$contact, 'id'=>$id, 'group_id'=>$responslist->group_id);
                echo json_encode($rtn); exit();
            }
            else{
                $rtn = array('success'=>'fail', 'message'=>'OTP Update failed', 'group_id'=>$responslist->group_id);
                echo json_encode($rtn); exit();
            }
        }
	}
}
else{
    if(strlen($contact)==9 or strlen($contact)==10){
        $code = explode(",", $_POST['country']);
        $contact1 = $code[0].$contact;
    $url="https://cloud.websms.lk/smsAPI?sendsms=null&apikey=cOpDat7cbjjThVUrL3BylWGPLskvmlyU&apitoken=rrl91673248290&type=sms&from=SOMARATNE%20D&to=".$contact1."&text=".urlencode($message)."&route=0";

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
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
    // echo $response;

    // echo $response = file_get_contents($url);
    $responselist =  json_decode($response);
        if($responselist->status == 'queued'){
            $minutes_to_add=15;
            $time = new DateTime(date('Y-m-d H:i:s'));
            $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
            $otpEndTime = $time->format('Y-m-d H:i:s');
            $sql = mysqli_query($con, "SELECT * FROM otpbucket WHERE mobile='$contact'");
            if($sql && mysqli_num_rows($sql)>0){
                $list = mysqli_fetch_assoc($sql);
                $id = $list['id'];
                $sqlu =  mysqli_query($con, "UPDATE otpbucket SET otp='$otp',datetime='$otpEndTime' WHERE id='$id'");
                if($sqlu){
                    $rtn = array('success'=>'true', 'message'=>'OTP sent to '.$contact, 'id'=>$id, 'group_id'=>$responslist->group_id);
                    echo json_encode($rtn); exit();
                }
                else{
                    $rtn = array('success'=>'fail', 'message'=>'OTP Update failed', 'group_id'=>$responslist->group_id);
                    echo json_encode($rtn); exit();
                }
            }
            else{
                $sqli = mysqli_query($con, "INSERT INTO otpbucket (mobile, otp, datetime) VALUES ('$contact', '$otp', '$otpEndTime')");
                if($sqli){
                    $id = mysqli_insert_id($con);
                    $rtn = array('success'=>'true', 'message'=>'OTP sent to '.$contact, 'id'=>$id, 'group_id'=>$responslist->group_id);
                    echo json_encode($rtn); exit();
                }
                else{
                    $rtn = array('success'=>'fail', 'message'=>'OTP Update failed', 'group_id'=>$responslist->group_id);
                    echo json_encode($rtn); exit();
                }
            }
        }
        else{
            $rtn = array('success'=>'fail', 'message'=>$responselist->message);
            echo json_encode($rt); exit();
        }

    }
    else{
        $rtn = array('success'=>'fail', 'message'=>'Invalid Mobile number');
        echo json_encode($rt); exit();
    }
}
 function generateRandomString($length = 4) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString; }
?>