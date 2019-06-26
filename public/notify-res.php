<?php	
	$servername = "localhost";
	$username = "dqld4glu_0ba5_cg";
	$password = "Develop@2018";
	$dbname = "dqld4glu_fp_qicpayws";
			
	$merchant_id         	= $_POST['merchant_id'];
	$old_order_id           = $_POST['order_id'];
	$payhere_amount     	= $_POST['payhere_amount'];
	$payhere_currency    	= $_POST['payhere_currency'];
	$status_code         	= $_POST['status_code'];
	$payment_id		        = $_POST['payment_id'];
	$md5sig                	= $_POST['md5sig'];
	
	$merchant_secret = '89de30c6e3af0a89c4e05f164df09909'; //'witel'; // Replace with your Merchant Secret (Can be found on your PayHere account's Settings page)
	
	$local_md5sig = strtoupper (md5 ( $merchant_id . $old_order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret)) ) );
	
	/*error_log($local_md5sig);
	error_log($md5sig);*/
	
	if (($local_md5sig === $md5sig) AND ($status_code == 2) ){
        
        $order_id = str_replace("FP_Order_#", "", $old_order_id);
		$order_id -= 100;

		/******
            STEP ONE TODO: Update your database as payment success
        *******/
	    $conn1 = new mysqli($servername, $username, $password, $dbname);
		
		if ($conn1->connect_error) {
		    //die("Connection failed: " . $conn->connect_error);
		    error_log($conn1->connect_error);
		}
		
		//error_log($order_id);
		$sql = "UPDATE orders SET status='2' WHERE id=$order_id";
		
		if ($conn1->query($sql) === TRUE) {
		    //echo "record updated successfully";
		    error_log($order_id. "record updated successfully");
		} else {
		    //echo "Error: " . $sql . "<br>" . $conn->error;
		    error_log("Error: " . $sql . "<br>" . $conn1->error);
		}

		$conn1->close();


		/******
            STEP TWO TODO: Get Order Details
        *******/
		$conn2 = new mysqli($servername, $username, $password, $dbname);
		if ($conn2->connect_error) {
			die("Connection failed: " . $conn2->connect_error);
		} 
		$sql = "SELECT * FROM orders WHERE id = $order_id";
		$result = $conn2->query($sql);
		while($row = $result->fetch_assoc()) {
			$first_name = $row['first_name'];
			$email = $row['email'];
			//$address = $row['address'];
			$bPhoneNumber = $row['phone'];
			$purchase_date = $row['created_at'];
			//$rPhoneNumber = $row['delivery_phone'];
			//$delivery_date = $row['delivery_date'];
			$total = $row['total'];
		}
		$conn2->close(); 
        //echo($order_id);
        //$order_id = 63;
        
		/******
            STEP THREE TODO: Send Email
        *******/
		$to ="shafna@witellsolutions.com,$email";
		$from = "support@flowershoplk.com";
		$subject = "Purchase Confirmation";		
				
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=ISO-8859-1" . "\r\n";
		$headers .= "X-Priority: 1 (Highest)\n";
		$headers .= "X-MSMail-Priority: High\n";
		$headers .= "From: " . $from . "\r\n";							
		$headers .= "Reply-To: " . $from . "\r\n";
		
		$message =
		"<html>
        <head>
		<style>
			@import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700');
			body { background: #eee; color: #4c4c4c; font-family: 'Open Sans', sans-serif;}
			table { border: 1px solid #ddd; border-collapse: separate; border-left: 0; border-radius: 4px; width: 100%; }
			th { text-align:left; padding: 1rem; border-left: 1px solid #ddd;}
			td { border-left: 1px solid #ddd; padding: 8px; line-height: 20px; text-align: left; vertical-align: top; border-top: 1px solid #ddd;}
			label { margin: 1rem; padding: 1rem; }
			.container { margin: 0 auto; width: 50%; background: #fff;}
			.header { background: #fff; padding: 10px; overflow: hidden; border-bottom: 3px solid #d5006e;}
			.header .logo{ float: left; }
			.header .info { float: right; margin-top: 25px;}
			.header .info h3, .header .info h4{ color: black; margin: 0; font-weight: 100; text-align: right; line-height: 30px}
			.body { padding: 20px; }
			.body p{ color: #4c4c4c; text-transform: capitalize; }
			.body p span{ text-transform: lowercase; }
			.body h3{ background: #d5006e; padding: 15px; color: #fff; margin-bottom: 0;}
			.footer { background:#fff;padding:10px;margin-top:30px; border-top: 3px solid #d5006e; overflow: hidden;}
		</style>
		</head>
		<body>
		<div class='container'>
	            <div class='header'>
					<div class='logo'><img src='http://flowershoplk.com/images/logo.png'></div>
					<div class='info'><h3>". $_POST['order_id'] ."</h3><h3>Purchased on :". date("d/M/Y", strtotime($purchase_date)) ."</h3></div>
	            </div>
                <div class='body'>";                       
        $message .=            
                    "<p>
                        ".$first_name.",<br/>
	                    ".$bPhoneNumber."<br/>
	                    <span>".$email."<span>
                    </p>";                    
        $message .=     
                    "<h3>ORDER SUMMARY</h3>	
					<hr class='soft'/>";
			// Order related Details
			$conn3 = new mysqli($servername, $username, $password, $dbname); 
			if ($conn3->connect_error) {
				die("Connection failed: " . $conn3->connect_error);
			}
			$sql = "SELECT * FROM order_items WHERE order_id = $order_id";
			$result = $conn3->query($sql);       
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {	
		$message .= "<table>
	                    <thead>
	                        <tr>
	                            <th>Product</th>
	                            <th>Description</th>
	                            <th>Quantity</th>
								<th>Price</th>
								<th>Delivery Fee</th>
	                            <th>Total</th>                        
	                        </tr>
	                    </thead>
						<tbody>";							 
		$message .=     	"<tr>
								<td><img width='60' src='http://flowershoplk.com/product-photos/".$row['product_image']."' alt=''/></td>
								<td>".$row['product_name']."</td>
								<td>".$row['product_qty']."</td>
								<td>".$row['product_price']."</td>
								<td>".$row['product_delivery_fee']."</td>";
								$price = ($row['product_price'] + $row['product_delivery_fee']) * $row['product_qty'];
		$message .=             "<td>". number_format($price, 2) . "</td>
							</tr>"; 
		$message .=    "</tbody>
					</table>";
		$message .= "<p>Delivery Date 				:". $row['delivery_date'] ."</p>";
		$message .= "<p>Delivery Address 			:". $row['delivery_address'] ."</p>";
		$message .= "<p>Delivery City 				:". $row['delivery_city'] ."</p>";
		$message .= "<p>Delivery Phone 				:". $row['delivery_phone'] ."</p>";
		$message .= "<p>Delivery Special Note 		:". $row['delivery_special_note'] ."</p>";
				}
			}
			$conn3->close();  
		$message .= 	"<p>We will contact you as soon as possible regarding this order. Keep in touch.</p>
	            </div>
	            <div class='footer'>
					<img src='http://flowershoplk.com/images/logo.png' alt='' width='200' style='float:left;margin-bottom:5px'>
	                <div style='float: right'>
	                    <!--<h3 style='color:#000;margin-top:5px;margin-bottom:10px'>FlowerShoplk</h3>-->
	                    <p style='margin-left:6px;font-size:12px;color:#000;text-align: right;'>27-1/3,York Arcade Building,<br/>
							Leyden Bastian Rd,<br> 
	                        Colombo 00100<br> 
							Sri Lanka
						</p>
	                    <p style='margin-left:6px margin-bottom:0px;margin-top:5px;font-size:12px;color:#000;text-align: right'>+1-877-926-5025</p>
	                </div>
	            </div>            
	        </div>
		</body>
		</html>";			
		//echo($order_id);
		
		//send mail
		$sendUser = mail($to,$subject,$message,$headers);

		/******** 
		 * Send SMS *
		********/
		include 'send-sms.php';

		// Send SMS to buyer
		$bMessage 		= 'Thank you for ordering from FlowerShoplk. Order ID:';
		$bMessage		.= $old_order_id;
		$bMessage		.= '. Amount:';
		$bMessage		.= number_format($total, 2);
		$bMessage		.= '. Call center: 0113010005';
		$bMessage		.= '. Our agents will contact you soon.';
		sendSMS($bPhoneNumber,$bMessage,$order_id,'buyer'); 

		
		$conn4 = new mysqli($servername, $username, $password, $dbname); 
		if ($conn4->connect_error) {
			die("Connection failed: " . $conn4->connect_error);
		}
		$sql = "SELECT * FROM order_items WHERE order_id = $order_id";
		$result = $conn4->query($sql);       
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				
				// Send SMS to reciever
				$rMessage		='Your order has been placed. Delivery date: ';
				$rMessage		.= $row['delivery_date'];
				$rMessage		.=' Shop: ';
				$rMessage		.= $row['product_shop_phone'];
				$rMessage		.='. Call center: 0113010005';
				$rMessage		.='. Thank you for choosing FlowerShoplk.';
				
				sendSMS($row['delivery_phone'],$rMessage,$order_id,'receiver');
				
				// Send SMS to florist
				$fMessage		='Order ID:';
				$fMessage		.= $old_order_id;
				$fMessage		.=' Product Code:';
				$fMessage		.= $row['product_code'];
				$fMessage		.=' Qty:';
				$fMessage		.= $row['product_qty'];
				$fMessage		.= ' Amount:';
				$fMessage		.= ($row['product_price'] + $row['product_delivery_fee']) * $row['product_qty'];
				
				sendSMS($row['product_shop_phone'],$fMessage,$order_id,'florist');
			}
		}		        
	}                       
                            
?>