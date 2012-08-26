    <?php
		include('config/config.php');
		//$message = $_REQUEST['txtweb-message'];
		//$number = $_REQUEST['txtweb-mobile'];

		//$category_name=$_GET['category'];
		$product_name=$_GET['product'];
		$total=0;		
		$db_handle = mysql_connect($server, $user_name, $password) or die (mysql_error());

		//$db_found = mysql_select_db($database, $db_handle);
		$db_found = mysql_select_db($database);

		if ($db_found) {
			$product_sql = "Select DISTINCT b.id,a.product_name,a.price,a.quantity,b.name,b.address,b.phone,b.region,b.latitude,b.longitude From Stores as b LEFT JOIN Products as a ON a.shop_id = b.id where a.product_name LIKE '%".$_GET['product']."%' ORDER BY a.price LIMIT 0,5";
			//echo $product_sql;			
			$results = mysql_query($product_sql);
			//echo $results;
			$total = 1;	
			while( $row = mysql_fetch_array($results) ){
				//if($total == 6) break;
				//echo "<tr id='driver_{$row['DriverId']}'>";
				$pro_name = $row['product_name'];
				$pro_price = $row['price'];
				$pro_quantity = $row['quantity'];
				$pro_shopname = $row['name'];
				$pro_address = $row['address'];
				$pro_phone= $row['phone'];
				$pro_region = $row['region'];
				
				$data[$total] = array(
					'pro_name' => $pro_name,
					'pro_price' => $pro_price,
					'pro_quantity' => $pro_quantity,
					'pro_shopname' => $pro_shopname,
					'pro_address' => $pro_address,
					'pro_phone' => $pro_phone,
					'pro_region' => $pro_region,
					'pro_lat' => $row['latitude'],
					'pro_lng' => $row['longitude'],
				);
				$total ++;
			
			}
			$data[0] = array(
			'count' => $total-1,
			);		
			echo json_encode($data);
		}
		else {
			print "Database NOT Found ";
		}
  
   
   
   //echo $message . "->" . $number . "end";
    ?>
