<html>
    <head>
    <title> Search 4 You </title>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<meta name='txtweb-appkey' content='afd1ec37-2586-40ee-89a7-b0347ff282ca' />
    </head>
    <body>
    <?php
		include('config/config.php');
		$message = $_REQUEST['txtweb-message'];
		$number = $_REQUEST['txtweb-mobile'];
		
		//echo $message . "->" . $number . "end";
		//exit;
		//echo 121212;
		
		//$message = "0,2;9788131720479,400,7;9780195681581,234,9"; // msg to 9243342000
		//$number  = "8950072d-a6f2-469f-be83-9d99327c8bdb";
		
		//$message = "0,1;9898989975,234,9"; // msg to 9243342000
		//$number  = "8950072d-a6f2-469f-be83-9d99327c8bdb";
		
		$data = explode(";",$message);
		$flag = (explode(",", $data[0]));
		//$total = (explode(",", $data[0]))[1];
		
		$barcode =0;
		$price=0;
		$quantity=0;
		$shop_id=0;
		$product_name='rrr';
		
	 //   echo $server . " -> " . $user_name;
		
		$db_handle = mysql_connect($server, $user_name, $password) or die (mysql_error());

		//$db_found = mysql_select_db($database, $db_handle);
		$db_found = mysql_select_db($database);

		if ($db_found) {
			
			$xpath='//table[@id="searchresultdata"]/tr[2]/td[1]/a';
			
			if($flag[0] == 0){
				
				//for($i=1;$i<=$total;$i++){
				for($i=1;$i<=$flag[1];$i++){
					
					$product_id=-1;
					
					//$barcode = explode(",",$data[$i])[0];
					//$price = explode(",",$data[$i])[1];
					//$quantity = explode(",",$data[$i])[2];
					$detail =  explode(",",$data[$i]);
					
					//$Curl_Session = curl_init('http://searchupc.com/default.aspx');
					// curl_setopt ($Curl_Session, CURLOPT_POST, 1);
					// curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, "q=" . $detail[0] . "");
					// curl_setopt ($Curl_Session, CURLOPT_FOLLOWLOCATION, 1);
					// $yo = curl_exec ($Curl_Session);
					// $results = json_decode($yo);
					// //print_r($yo);
					// //print_r($results);
					// echo $results;
					// //curl_close ($Curl_Session);
					
					$query = urlencode("select * from html where url='http://searchupc.com/upc/" . $detail[0] . "' and xpath='" . $xpath . "'");

					$url = "http://query.yahooapis.com/v1/public/yql?q=$query&format=json";
					$ch = curl_init();
					$headers = array();
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					$srp = curl_exec($ch);
					
					$results = json_decode($srp,true);
					
					//echo "<pre>";
					//echo var_export($results, true);
					//echo "</pre>"; 
					
					$product_name = $results['query']['results']['a']['content'];
					//echo $product_name;
					
					$check_sql = "Select id from Products Where barcode = '" . $detail[0] . "'" ;
					$check = mysql_query($check_sql);
					//echo $detail[0] . "<br>";
					if($check){
						while( $row = mysql_fetch_array($check) ){
							$product_id = $row['id'];
						}
						
					}
					
					if($product_id == -1){
						$insertProduct_sql = "INSERT INTO Products (id,shop_id,barcode,product_name,price,quantity) 
											VALUES (null,
												(Select id from Stores Where mobile_hash = '". $number . "'),
												'". $detail[0] ."',
												'" . $product_name . "',
												". $detail[1] . ",
												" . $detail[2] . " )";
						//echo $insertProduct_sql;
												
						$insertProduct = mysql_query($insertProduct_sql);
						
						if($insertProduct){
							echo "Done ";
						}else{
							echo "Error ";
						}
					}else{
						//echo $product_id;
						$updateProduct_sql  = "UPDATE Products 
												SET quantity = quantity + " . $detail[2] . "
													WHERE id = " . $product_id . "";
						//echo $updateProduct_sql;
						$updateProduct = mysql_query($updateProduct_sql);
						
						if($updateProduct){
							echo "Updated" ;
						}else{
							echo "ErrorUpdt". mysql_error();
						}
						
						
					}
						
				}
			}
			else{
				$detail =  explode(",",$data[1]);

				$check_sql = "Select id from Products Where barcode = '" . $detail[0] . "'" ;
					$check = mysql_query($check_sql);
					//echo $detail[0] . "<br>";
					if($check){
						while( $row = mysql_fetch_array($check) ){
							$product_id = $row['id'];
						}
						
					}
					
				$updateProduct_sql  = "UPDATE Products 
										SET quantity = quantity - " . $detail[2] . "
											WHERE id = " . $product_id . "";
				
				$updateProduct = mysql_query($updateProduct_sql);
				
				if($updateProduct){
					echo "Updated-";
				}else{
					echo "ErrorUp-";
				}
			
			}
			
		}
		else {
			print "Database NOT Found ";
		}
    ?>
</body>
</html>
