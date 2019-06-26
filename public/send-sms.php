<?php

function sendSMS($phoneNumber,$smsMessage,$order_id,$type){ 
	
	error_log('Phone_num: '. $phoneNumber);

	$companyId 		= 'WIT371';
	$pword 			= 'WIT371';
	

	if ($companyId && $pword && $phoneNumber && $smsMessage) {
	
		$url = "http://119.235.1.63:4050/Sms.svc/SendSms?phoneNumber=".$phoneNumber."&smsMessage=".urlencode($smsMessage)."&companyId=".$companyId."&pword=".$pword;
		//$url= "http://119.235.1.63:4050/Sms.svc/SendSms?phoneNumber=0777153193&smsMessage=New Order from FPP&companyId=WIT371&pword=WIT371";
	
		# code...
		$ch = curl_init(); 

	    curl_setopt($ch,CURLOPT_URL, $url);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	    curl_setopt($ch,CURLOPT_HEADER, 0); 
	 
	    $output=curl_exec($ch);
		
		if($output === false) {
			error_log("Error Number:".curl_errno($ch)."<br>");
			error_log("Error String:".curl_error($ch)."<br>");
		}
		else {
			
			//error_log("record updated successfully 2");
			
			// Save SMS details to db
			$conn = new mysqli("localhost", "dqld4glu_0ba5_cg", "Develop@2018", "dqld4glu_fp_qicpayws");
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 

			if($type == 'buyer') {
				$sql = "INSERT INTO sms_details (order_id, phone, sms_type)
				VALUES ($order_id, '$phoneNumber', '$type')";
			}
			else if ($type == 'receiver'){
				$sql = "INSERT INTO sms_details (order_id, phone, sms_type)
				VALUES ($order_id, '$phoneNumber', '$type')";
			}
			else if($type == 'florist'){
				$sql = "INSERT INTO sms_details (order_id, phone, sms_type)
				VALUES ($order_id, '$phoneNumber', '$type')";
			}			

			if ($conn->query($sql) === TRUE) {
				error_log("record updated successfully sms");
			} else {
				error_log("Error: " . $sql . "<br>" . $conn->error);
			}

			$conn->close();
			
		}
		
		curl_close($ch);  

		error_log(json_encode($output)); 
		error_log("******************************************"."</br>");
	}
	else {
		error_log("Invalid data!"."</br>");
	}
}
?>