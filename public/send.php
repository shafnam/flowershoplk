<?php 

//$companyId  	= isset($_REQUEST['companyId']) ? $_REQUEST['companyId'] : false; 
//$pword 	= isset($_REQUEST['pword']) ? $_REQUEST['pword'] : false; 
//$phoneNumber	= isset($_REQUEST['phoneNumber']) ? $_REQUEST['phoneNumber'] : false; 
//$smsMessage 	= isset($_REQUEST['smsMessage']) ? $_REQUEST['smsMessage'] : false; 
$loop 		= isset($_REQUEST['loop']) ? $_REQUEST['loop'] : 1; 

$phoneNumber	='0777153193';
$smsMessage 	= 'Hello World';
$companyId 	= 'WIT371';
$pword 		= 'WIT371';

if ($companyId && $pword && $phoneNumber && $smsMessage) {
	
	$url = "http://119.235.1.63:4050/Sms.svc/SendSms?phoneNumber=".$phoneNumber."&smsMessage=".urlencode($smsMessage)."&companyId=".$companyId."&pword=".$pword;
	//$url= "http://119.235.1.63:4050/Sms.svc/SendSms?phoneNumber=0777153193&smsMessage=New Order from FPP&companyId=WIT371&pword=WIT371";

	for ($i=0; $i < $loop; $i++) { 
	    # code...
	    $ch = curl_init(); 

	    curl_setopt($ch,CURLOPT_URL, $url);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		//  curl_setopt($ch,CURLOPT_HEADER, false); 
	 
	    $output=curl_exec($ch);
	 
	    if($output === false) {
	        echo "Error Number:".curl_errno($ch)."<br>";
	        echo "Error String:".curl_error($ch)."<br>";
	    }
	    
	    curl_close($ch);  

	    echo json_encode($output); 
	    echo "******************************************"."</br>";
	} 
	echo '<a href="./index.php">back</a>'."</br>";
}
else {
	echo "Invalid data!"."</br>"; 
	echo '<a href="./index.php">back</a>';
}


?>