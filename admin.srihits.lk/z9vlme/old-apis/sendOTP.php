<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$mobile=$obj['mobile'];
$email=$obj['email'];
$platform = $obj['platform'];
$signature = $obj['signature'];
$Motp=0;
$Eotp=0;
$otp = generateRandomString();
$message = 'Your One Time Password '.$otp;

// $mobile=$_GET['mobile'];
//$message=$_GET['message'];
// $email=$_GET['email'];
if($mobile!=''){
$xml_data ='<?xml version="1.0"?>
			<parent>
			<child>
			<user>MARKLABS</user>
			<key>8fbed6742fXX</key>
			<mobile>' . $mobile . '</mobile>
			<message>' . $message .'</message>
			<accusage>1</accusage>
			<senderid>INFOTP</senderid>
			</child>
			</parent>';

			$URL = "http://sms.bulkssms.com/submitsms.jsp?"; 

			$ch = curl_init($URL);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
		
			 //$result=explode(",",$output);
	$result = preg_split("/\,/",$output);
	$status = trim($result[0]);
			//print_r($status);
       if($status=='sent'){
		   $Motp=1;
	   }
}
	
            $output='<p>Dear user,</p>';
			$output.='<p>Please Enter the otp.</p>';
			$output.='<p style="font-size:24px;"><b>'.$message.'</b></p>';	
			$output.='<p>Thanks,</p>';
			$output.='<p>With Regards</p>';
			$output.='<p>Srihits</p>';
			$mail_body = $output; 
			$subject = "Verification - Application";
			$email_to = $email;
			$fromserver = "noreply@venavis.in"; 
			require("PHPMailer/PHPMailerAutoload.php");
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host = "smtp.gmail.com"; // Enter your host here
			$mail->SMTPAuth = true;
			$mail->Username = "vensframe@gmail.com"; // Enter your email here
			$mail->Password = "Vensframe@8510"; //Enter your passwrod here
			$mail->Port = 25 ;
			$mail->IsHTML(true);
			$mail->From = "noreply@venavis.in";
			$mail->FromName = "Srihits";
			$mail->Sender = $fromserver; // indicates ReturnPath header
			$mail->Subject = $subject;
			$mail->Body = $mail_body;
			$mail->AddAddress($email_to);
			if(!$mail->Send())
			{
		  
			}
			else
			{
			    
				$Eotp=1;
			}
	  
		
   if($Motp==1&& $Eotp==1){
   $fin = array('success'=>'true','message'=>'OTP sent to mobile and email','otp'=>$otp);
   }
else if($Motp==1 && $Eotp==0){
$fin = array('success'=>'true','message'=>'OTP sent to mobile','otp'=>$otp);
}
else if($Motp==0 && $Eotp==1){
$fin = array('success'=>'true','message'=>'OTP sent to email','otp'=>$otp);
}
else{
$fin = array('success'=>'fail','message'=>'Please try again');
	  
}
 echo json_encode($fin);
 
 function generateRandomString($length = 4) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString; }
?>