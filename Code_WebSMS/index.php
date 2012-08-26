<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"> 
		<title>Street Market</title>
		<meta name="author" content="Gurpreet, Akarshan, Vedant and Anuj" /> 
		<meta name="copyright" content="&copy; 2012 Street Market Inc." /> 
	
		<link rel="stylesheet" media="screen" href="css/base.css?v=2" /> <!--Load CSS-->
	</head>
	<body>
		<div id='wrapper'>
			<div id='header'>
				<br><br><br><br><br><br>
			</div>
			<div id='mainContent'>
				<div id='mainHeading'><img id="logo" src="logo1.png" height="150" width="100%" /></div>
				
				<div id='mainData'>
					<label>Category</label>&nbsp;
					<select id="category" name="category" >
						<option value="None" selected="selected">None</option>
						<option value="Books">Books</option>
						<option value="Appliances">Appliances</option>
						<option value="Utensils">Utensils</option>
						<option value="Sports Wear">Sports Wear</option>
						<option value="Garments">Garments</option>
						<option value="Cosmetics">Cosmetics</option>
						<option value="Smart Phones">Smart Phones</option>
					</select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>Your Product</label>&nbsp;
					<input id='product' name='product' type="text" size="40"  />
					<div id='productSpace'></div>
					<a href="javascript:void(0);" class="button orange"  onclick="submitForm();"> Submit </a>
				</div>
				
				<div id='shopDetails'>
					
				</div>
			</div>
			<div id='map' class="shadow">
				<div id='map_header' onclick='hideMap();'>
					<div id='map_header_name' style='width:565px;display:inline-block;'>Shops Suggestions</div>
					<div id='map_header_close' style='display:inline-block;'><a href='javascript:hideMap();'><img src='delete.png' alt='close Map' height="15" width="15" /></a></div>
				</div>
				<div id='map_canvas'></div>
			</div>
			<div id='footer'>
				
			</div>
		</div>
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=true"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script><!--Load jQuery-->
		<script>!window.jQuery && document.write(unescape('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>
		<script src="js/script.js"></script>
	</body>
</html>
