<html>
<head>
    <title>Secure Acceptance - Payment Form Example</title>
    <link rel="stylesheet" type="text/css" href="payment.css"/>
    <script type="text/javascript" src="jquery-1.7.min.js"></script>
</head>
<body>
<form id="payment_form" action="payment_confirmation.php" method="post">

    <!--Replace Keys-->
	<input type="hidden" name="access_key" value="581accd2e25a3c22a5b6f5ee8b93456d">
    <input type="hidden" name="profile_id" value="595C1367-5A39-45B8-A31B-3D56DACD9479">
	
	
    <input type="hidden" name="transaction_uuid" value="<?php echo uniqid() ?>">
	
	<!--Check these Values-->
    <!-- <input type="hidden" name="signed_field_names" value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency">	
	<input type="hidden" name="unsigned_field_names" value="auth_trans_ref_no,bill_to_forename,bill_to_surname,bill_to_address_line1,bill_to_address_city,bill_to_address_country,bill_to_email"> -->
    
    <input type="hidden" name="signed_field_names" value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency">	
	<input type="hidden" name="unsigned_field_names" value="auth_trans_ref_no,bill_to_forename,bill_to_surname,bill_to_address_line1,bill_to_address_city,bill_to_address_country,bill_to_email">
    

	<input type="hidden" name="signed_date_time" value="<?php echo gmdate("Y-m-d\TH:i:s\Z"); ?>">
    <input type="hidden" name="locale" value="en">
    <fieldset>
        <legend>Payment Details</legend>
        <div id="paymentDetailsSection" class="section">
            <span>transaction_type:</span><input type="text" name="transaction_type" size="25" value="sale"><br/>
            <span>reference_number 1:</span><input type="text" name="reference_number" size="25" value="1664435352333"><br/>
			
			<!--Add this Parameter-->
			<span>reference_number 2:</span><input type="text" name="auth_trans_ref_no" size="25" value="123456789"><br/>
			
            <span>amount:</span><input type="text" name="amount" size="25" value="100.00"><br/>
            <span>currency:</span><input type="text" name="currency" size="25" value="LKR"><br/>
        </div>
    </fieldset>
	<!--Add these billing Parameters-->
	<input type="hidden" name="bill_to_email" value="erandikar@peoplesbank.lk"/>
	<input type="hidden" name="bill_to_forename" value="NOREAL"/>
	<input type="hidden" name="bill_to_surname" value='NAME'/>
	<input type="hidden" name="bill_to_address_line1" value="1295 Charleston Road "/>
	<input type="hidden" name="bill_to_address_city" value="MMs"/>
	<input type="hidden" name="bill_to_address_country" value="LK"/>
	
    <input type="submit" id="submit" name="submit" value="Submit"/>
    <script type="text/javascript" src="payment_form.js"></script>
</form>
</body>
</html>
