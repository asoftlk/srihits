<HTML>
<body>
   
   <?php //print_r($_REQUEST); ?> 
<form id='FrmHtmlCheckout' name='FrmHtmlCheckout' 
action='https://pgtd.peoplesbank.lk/OrderProcessingEngine/RedirectLink.aspx' method='post'>

<label>Version</label>
<input id='Version' type='text' name='Version' value='1.0.0'>
</br>
<label>MerID</label>
<input id='MerID' type='text' value='1000000000041' name='MerID'>
</br>
<label>AcqID</label>
<input id='AcqID' type='text' value='512940' name='AcqID'>
</br>
<label>MerRespURL</label>
<input id='MerRespURL' type='text' value='https://srihits.veramasait.com/response.php' name='MerRespURL'>
</br>
<label>PurchaseCurrency</label>
<input id='PurchaseCurrency' type='text' value='144' name='PurchaseCurrency'>
</br>
<label>PurchaseCurrencyExponent</label>
<input id='PurchaseCurrencyExponent' type='text' value='2' name='PurchaseCurrencyExponent'>
</br>
<label>OrderID</label>
<input id='OrderID' type='text' value='kurvriaziakjha' name='OrderID'>
</br>
<label>SignatureMethod</label>
<input id='SignatureMethod' type='text' value='SHA1' name='SignatureMethod'>
</br>
<label>PurchaseAmt</label>
<input id='PurchaseAmt' type='text' value='000000001000' name='PurchaseAmt'>
</br>
<label>Signature</label>

<!-- <input id='Signature' type='text' value='<?php echo base64_encode(SHA1('PasswordMerchantIDAcquirerIDOrderIDPurchaseAmountPurchaseCurrency',TRUE));?>' name='Signature'> -->
<input id='Signature' type='text' value='<?php echo base64_encode(SHA1('p4(L64yZ1000000000041512940kurvriaziakjha000000001000144',TRUE));?>' name='Signature'>
</br>
<label>Submit</label>
 <input type="submit" value="Submit">
	</form>	
	</body>
</HTML>