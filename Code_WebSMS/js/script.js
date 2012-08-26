var shops;
var shopsCount;
var directionsDisplay;
var directionsService;
var vehicleDisplay;
var map;
var myLatitude,myLongitude,myLocation;
var currentDirections = null;


$(document).ready(function() {
	
	$("#productSpace").html('<br><br>');
	
	if (navigator.geolocation)
    {
		navigator.geolocation.getCurrentPosition(showPosition);
    }
	else{
		myLatitude = 26.4583 ;
		myLongitude = 80.0173 ;
	}
	$("input").keydown(function(event) {
			// alert('You pressed '+event.keyCode);
			 if((event.keyCode)==13){
				submitForm();
			}else return;
			 event.preventDefault();
		});
	
});

function showPosition(position){

	myLatitude = position.coords.latitude;
	myLongitude = position.coords.longitude ;

}

function submitForm(){

	var product = $("#product").val() ;
	var category = $("#category").val() ;
	var shopHTML = "";
	//alert(product + '=' + category);
	$.ajax({
		type: "GET",
		url: 'process.php',
		dataType: 'json',
		data: {'product' : product , 'category' : category},
		success: function(data){
		
			shops = data;
			shopsCount = shops[0].count;
			//alert(shopsCount);
			
			if(shopsCount == 0){
				shopHTML += "<br><br><b>Sorry..!! No Result Matched.</b>";
			}else{
				shopHTML += "<br><font size='6'><b><u>Top Results For '" + product + "'</u></b></font><br>";
			}
			
			for(k=1; k<=shopsCount ; k++){
				
				shopHTML += "<div id='shop_" + k + "' style='text-align:left;margin:8px 5%;'>";
				shopHTML += "<div style='display:inline-block;text-align:left;width:53%;'>";
				shopHTML += k+".&nbsp;<font size='4'><b>" + shops[k].pro_name + "</b></font><br>&nbsp;&nbsp;&nbsp;&nbsp;Price : Rs." + shops[k].pro_price + "<br>";
				shopHTML += "&nbsp;&nbsp;&nbsp;&nbsp;In Stock : " + shops[k].pro_quantity + "</div>";
				
				shopHTML += "<div style='display:inline-block;text-align:left;width:35%;'><font size='4'>" + shops[k].pro_shopname + "</font><br>";
				shopHTML += "" + shops[k].pro_address + ", "+ shops[k].pro_region +"<br>";
				shopHTML += "" + "Phone:" + shops[k].pro_phone + "</div>";
				
				shopHTML += "<div style='display:inline-block;'>"
				shopHTML += "<a href='javascript:showMap("+ k +");' class='button green' style='margin-bottom:15px;' >Map</a><br><br>";
				shopHTML += "</div></div>";
				
			}
			$("#shopDetails").html(shopHTML);
			
			$("#header").html(" ");
			$("img[id=logo]").css('height',100).css('width','90%').css('margin-top', '10px');
			$("#mainContent").css('font-size', 17);
			$("a.button").css('padding', '.5em 2em .55em').css('font',' normal bold 13px/100% Arial, Helvetica, sans-serif');
			$("#productSpace").html('').css('display','inline-block');
			
		
		}
		
	});
	
}

function showMap(p){
	$("#map").css('visibility','visible');
	
	directionsDisplay = new google.maps.DirectionsRenderer({

					'preserveViewport': true,

					'draggable': true

				});
	directionsService = new google.maps.DirectionsService();

	myLocation = new google.maps.LatLng(myLatitude, myLongitude);

	geocoder = new google.maps.Geocoder();		

	var myOptions = {

		zoom: 11,

		mapTypeId: google.maps.MapTypeId.ROADMAP,

		center: myLocation

	}

	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	directionsDisplay.setMap(map);


	google.maps.event.addListener(directionsDisplay, 'directions_changed',

		function() {

		if (currentDirections) {

			oldDirections.push(currentDirections);

			setUndoDisabled(false);

		}

		currentDirections = directionsDisplay.getDirections();

	});
	
//alert("LL");
	//$("#map").offset().left = $("#mainData").offset().left + 2 + "px";
	//$("#map").style.left = $("#shopDetails").style.left + 2 + "px";
	document.getElementById('map').style.left = parseInt(document.getElementById('shopDetails').style.left) + 2 + "px";
	document.getElementById('map').style.top = parseInt(document.getElementById('shopDetails').style.top) + 200 + "px";
	//$("#map").style.top = $("#shopDetails").style.top + 2 + "px";
	//$("#map").offset().top = $("#mainData").offset().top + 2 + "px";
	
	
	vehicleDisplay = new google.maps.InfoWindow();
	//alert(shops[p].pro_lat + "---" + myLatitude);
	var shopLatLng = new google.maps.LatLng(shops[p].pro_lat, shops[p].pro_lng, true);
	
	var request = {

					origin: myLocation,

					destination: shopLatLng,

					travelMode: google.maps.DirectionsTravelMode.DRIVING,

					provideRouteAlternatives: false

				};

			directionsService = new google.maps.DirectionsService();

			directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
				  directionsDisplay.setDirections(result);
				}
			  });
}

function hideMap(){
	$("#map").css('visibility','hidden');
}


