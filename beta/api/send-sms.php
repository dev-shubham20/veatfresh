<?php 
function sendSms($mobile, $message)
{
	//Your message to send, Add URL encoding here.
	$message = urlencode($message);
	
	//Prepare post parameters
	$postData = array(
		'authkey' => 'YOUR_KEY',
		'sender' => 'SENDER_ID'
	);
	
	//API URL
	$url = "http://yoursmspackage.com/rest/services/sendSMS/sendGroupSms?";
	$url .= "AUTH_KEY=".$postData['authkey']."&message=".$message."&senderId=".$postData['sender']."&routeId=1&mobileNos=".$mobile."&smsContentType=english";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch); 
	if (curl_errno($ch)) {
		echo 'error:' . curl_error($ch);
	}
	curl_close($ch);
}
?>