     <html>
    <head>
    <title> Hello! </title>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name='txtweb-appkey' content='afd1ec37-2586-40ee-89a7-b0347ff282ca' />
    </head>
    <body>
    <?php
    	$message = $_REQUEST['txtweb-message'];
	//$message='HELP';
	if($message=='HELP'){
		echo "HELP:";
		echo "<br>";
		echo "Type : @search4you.user [Item type],[Item name]";
		echo "<br>";
		echo "Send to 9243342000";
		echo "<br>";
		echo "For example: @search4you.user Book,Game";
	
	}
	else{
	include('config/config.php');
	$data = explode(",",$message);

	$db_handle = mysql_connect($server, $user_name, $password) or die (mysql_error());
	$db_found = mysql_select_db($database);

		if ($db_found) {
	$product_sql = "Select a.product_name,a.price,a.quantity,b.name,b.address,b.phone,b.region From Products as a LEFT JOIN Stores as b ON a.shop_id = b.id where a.product_name LIKE '%".$data[1]."%' ";

	$results = mysql_query($product_sql);
			//echo $results;
				
			while( $row = mysql_fetch_array($results) ){
				//if($total == 6) break;
				//echo "<tr id='driver_{$row['DriverId']}'>";
				echo $row['product_name'].', '.$row['price'].', '.$row['name'].', '.$row['address'].', '.$row['phone'].', '.$row['region'];
				echo "<br>";
				/*$pro_shopname = $row['name'];
				$pro_address = $row['address'];
				$pro_phone= $row['phone'];
				$pro_region = $row['region'];*/
			
			}


	}
	else {
			print "Database NOT Found ";
	}
	}
    ?>
    </body>
    </html>
