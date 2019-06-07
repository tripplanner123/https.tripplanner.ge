var map = "";
function initMap() {
	var myLatLng = {lat: 41.63514628349129, lng: 41.62310082006843};    
    map = new google.maps.Map(document.getElementById('SidebarSmallMap'), {
        zoom: 6,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var directionsService = new google.maps.DirectionsService();
	var directionsDisplay = new google.maps.DirectionsRenderer();
   
	$(document).on("change", ".guestsN", function(){
		countAdditionalServices();
		directionsDisplay.setMap(map);
    	directionsDisplay.setOptions( { polylineOptions: {
				strokeColor: "#12693b"
			}, suppressMarkers: true } );
    	setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
	});

    $(document).on("change", "#mobile-guest", function(){
    	var val = $(this).val();
    	$(".input-number").val(val);

    	var children = $(".planner-children").val();
    	var childrenunder = $(".planner-childrenunder").val();
    	countAdditionalServices();

    	$(".planner-transport").prop("checked", false);

    	var totalCrow = parseInt(val) + parseInt(children) + parseInt(childrenunder);
    	if(totalCrow>=4 && totalCrow<=6){// minivan
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra126']").val()+"</text>");
    		$(".planner-transport[id='tra126']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(126);
    	}else if(totalCrow>=7){//bus
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra127']").val()+"</text>");
    		$(".planner-transport[id='tra127']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(127);
    	}else{//car
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra125']").val()+"</text>");
    		$(".planner-transport[id='tra125']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(125);
    	}

    	directionsDisplay.setMap(map);
    	directionsDisplay.setOptions( { polylineOptions: {
				strokeColor: "#12693b"
			}, suppressMarkers: true } );
    	setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
    });


    $(document).on("change", "#mobile-child", function(){
    	var val = $(this).val();
    	$(".planner-children").val(val);
    	countAdditionalServices();

    	var adults = $(".input-number").val();
    	var underchild = $("#mobile-underchild").val();
    	$(".planner-transport").prop("checked", false);

    	var totalCrow = parseInt(val) + parseInt(adults) + parseInt(underchild);
    	if(totalCrow>=4 && totalCrow<=6){// minivan
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra126']").val()+"</text>");
    		$(".planner-transport[id='tra126']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(126);
    	}else if(totalCrow>=7){//bus
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra127']").val()+"</text>");
    		$(".planner-transport[id='tra127']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(127);
    	}else{//car
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra125']").val()+"</text>");
    		$(".planner-transport[id='tra125']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(125);
    	}

    	directionsDisplay.setMap(map);
    	directionsDisplay.setOptions( { polylineOptions: {
				strokeColor: "#12693b"
			}, suppressMarkers: true } );
    	setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
    });

    $(document).on("change", "#mobile-underchild", function(){
    	var val = $(this).val();
    	$(".planner-childrenunder").val(val);
    	var adults = $(".input-number").val();
    	var child = $("#mobile-child").val();

    	var totalCrow = parseInt(val) + parseInt(adults) + parseInt(child);
    	if(totalCrow>=4 && totalCrow<=6){// minivan
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra126']").val()+"</text>");
    		$(".planner-transport[id='tra126']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(126);
    	}else if(totalCrow>=7){//bus
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra127']").val()+"</text>");
    		$(".planner-transport[id='tra127']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(127);
    	}else{//car
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra125']").val()+"</text>");
    		$(".planner-transport[id='tra125']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(125);
    	}
    });

    $(document).on("change", ".planner-childrenunder", function(){
    	var val = $(this).val();
    	countAdditionalServices();
    	var adults = $(".input-number").val();
    	var child = $(".planner-children").val();
    	$(".planner-transport").prop("checked", false);

    	var totalCrow = parseInt(val) + parseInt(adults) + parseInt(child);
    	if(totalCrow>=4 && totalCrow<=6){// minivan
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra126']").val()+"</text>");
    		$(".planner-transport[id='tra126']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(126);
    	}else if(totalCrow>=7){//bus
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra127']").val()+"</text>");
    		$(".planner-transport[id='tra127']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(127);
    	}else{//car
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra125']").val()+"</text>");
    		$(".planner-transport[id='tra125']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(125);
    	}

    	directionsDisplay.setMap(map);
    	directionsDisplay.setOptions( { polylineOptions: {
				strokeColor: "#12693b"
			}, suppressMarkers: true } );
    	setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
    });

    $(document).on("change", ".input-number", function(){
    	var val = $(this).val();
    	countAdditionalServices();

    	var children = $(".planner-children").val();
    	var childrenunder = $(".planner-childrenunder").val();
    	$(".planner-transport").prop("checked", false);

    	var totalCrow = parseInt(val) + parseInt(children) + parseInt(childrenunder);
    	if(totalCrow>=4 && totalCrow<=6){// minivan
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra126']").val()+"</text>");
    		$(".planner-transport[id='tra126']").prop("checked", true);
    	}else if(totalCrow>=7){//bus
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra127']").val()+"</text>");
    		$(".planner-transport[id='tra127']").prop("checked", true);
    	}else{//car
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra125']").val()+"</text>");
    		$(".planner-transport[id='tra125']").prop("checked", true);
    	}

    	directionsDisplay.setMap(map);
    	directionsDisplay.setOptions( { polylineOptions: {
				strokeColor: "#12693b"
			}, suppressMarkers: true } );
    	setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
    });

    $(document).on("change", ".planner-children", function(){
    	countAdditionalServices();

    	var val = $(this).val();
    	var adults = $(".input-number").val();
    	var childrenunder = $(".planner-childrenunder").val();
    	$(".planner-transport").prop("checked", false);

    	var totalCrow = parseInt(val) + parseInt(adults) + parseInt(childrenunder);
    	if(totalCrow>=4 && totalCrow<=6){// minivan
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra126']").val()+"</text>");
    		$(".planner-transport[id='tra126']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(126);
    	}else if(totalCrow>=7){//bus
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra127']").val()+"</text>");
    		$(".planner-transport[id='tra127']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(127);
    	}else{//car
    		$(".TransportValue").html("<text>"+$(".planner-transport[id='tra125']").val()+"</text>");
    		$(".planner-transport[id='tra125']").prop("checked", true);
    		$(".mobile-TransporDropDown").val(125);
    	}

    	directionsDisplay.setMap(map);
    	directionsDisplay.setOptions( { polylineOptions: {
				strokeColor: "#12693b"
			}, suppressMarkers: true } );
    	setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
    });

    $(document).on("change", ".CheckBoxItem input[type='checkbox']", function(){
    	$(".SidebarDaysList").html("");
    	$(".SumCount span.gelprice").html("0");
    	var val = $(this).val();
    	var dier = $(this).attr("data-map");
    	var cate = $(this).attr("data-categories");
    	var title = $(this).attr("data-title");

    	if($(this).prop("checked") && dier != ""){
    		var input = "<input type=\"hidden\" name=\"plantrip_direction[]\" id=\"plantrip_direction"+val+"\" data-map=\""+dier+"\" data-categories=\""+cate+"\" data-title=\""+title+"\" value=\""+val+"\" />";
    		$("#plantripform").append(input);
    	}else{
    		$("#plantrip_direction"+val).remove();
    	}
    	directionsDisplay.setMap(map);
    	directionsDisplay.setOptions( { polylineOptions: {
				strokeColor: "#12693b"
			}, suppressMarkers: true } );
    	setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
    }); 

    $(document).on("change", ".mobile-placesbox .Item input[type='checkbox'] ", function(){
    	$(".SidebarDaysList").html("");
    	$(".SumCount span.gelprice").html("0");
    	var val = $(this).val();
    	var dier = $(this).attr("data-map");
    	var cate = $(this).attr("data-categories");
    	var title = $(this).attr("data-title");

    	if($(this).prop("checked") && dier != ""){
    		var input = "<input type=\"hidden\" name=\"plantrip_direction[]\" id=\"plantrip_direction"+val+"\" data-map=\""+dier+"\" data-categories=\""+cate+"\" data-title=\""+title+"\" value=\""+val+"\" />";
    		$("#plantripform").append(input);
    	}else{
    		$("#plantrip_direction"+val).remove();
    	}
    	directionsDisplay.setMap(map);
    	directionsDisplay.setOptions( { polylineOptions: {
				strokeColor: "#12693b"
			}, suppressMarkers: true } );
    	setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
    });

   //  $(document).on("click", ".btn-number", function(){
   //  	directionsDisplay.setMap(map);
   //  	directionsDisplay.setOptions( { polylineOptions: {
			// 	strokeColor: "#12693b"
			// }, suppressMarkers: true } );
   //  	setTimeout(function(){
   //  		updateDirections(google, directionsService, directionsDisplay);
   //  	}, 500);
   //  });

    $('.LocationDropDown2 input').change(function() {
       	directionsDisplay.setMap(map);
    	directionsDisplay.setOptions( { polylineOptions: {
				strokeColor: "#12693b"
			}, suppressMarkers: true } );
    	setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
    });

    $(document).on("change", ".planner-hotels", function(){
		var dataparent = $(this).attr("data-parent");

		var dataID = $(this).attr("data-hotelid");
		$(".planner-hotels").prop('checked', false);
		$(".planner-hotels[data-hotelid='"+dataID+"']").prop('checked', true);
		
		if (this.checked) {
			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.hostelValue').html($li);
			
		} else {
			$('text:contains('+this.value+')', '.hostelValue').remove();
		}

		if($(this).prop("checked")){
			$("#"+dataparent).prop("checked", true);
		}	

	    countAdditionalServices();	
	    setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);					    
	    
	});

	$(document).on("change", ".mobile-HotelsDropDown", function(){
		var dataparent = $(this).attr("data-parent");

		var dataID = $(this).val();
		$(".planner-hotels").prop('checked', false);
		$(".planner-hotels[data-hotelid='"+dataID+"']").prop('checked', true);
		
		if (this.checked) {
			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.hostelValue').html($li);
			
		} else {
			$('text:contains('+this.value+')', '.hostelValue').remove();
		}

		$("#"+dataparent).prop("checked", true);	

	    countAdditionalServices();	
	    setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
	});


	$(document).on("change", ".mobile-LanguageDropDown", function(){
		var dataparent = $(this).attr("data-parent");

		var dataID = $(this).val();
		$(".planner-guide").prop('checked', false);
		$(".planner-guide[data-guideid='"+dataID+"']").prop('checked', true);
		
		if (this.checked) {
			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.LangValue').html($li);
			
		} else {
			$('text:contains('+this.value+')', '.LangValue').remove();
		}

		$("#"+dataparent).prop("checked", true);	

	    countAdditionalServices();	
	    setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
	});

	$(document).on("change", ".mobile-TransporDropDown", function(){
		var dataparent = $(this).attr("data-parent");

		var dataID = $(this).val();
		$(".planner-transport").prop('checked', false);
		$(".planner-transport[id='tra"+dataID+"']").prop('checked', true);
		
		if (this.checked) {
			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.TransportValue').html($li);
			
		} else {
			$('text:contains('+this.value+')', '.TransportValue').remove();
		}

		$("#"+dataparent).prop("checked", true);	

	    countAdditionalServices();	
	    setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);
	});

	$(document).on("change", ".planner-cuisune", function(){
	    var dataparent = $(this).attr("data-parent");
	    $('.CuisineValue').html('');
	    $(".planner-cuisune").each(function(){
	        var id = $(this).attr("id");
			if (this.checked) {
				$li = $(' <text> </text> ');
				$li.text(this.value);
				$('.CuisineValue').append($li);
			} else {
				$('text:contains('+this.value+')', '.CuisineValue').remove();
			}

	        if($(this).prop("checked")){
				$("#"+dataparent).prop("checked", true);
			}
	    });		

	    countAdditionalServices();		
	    setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);				    
	    
	});

	$(document).on("change", ".planner-guide", function(){
	    var dataparent = $(this).attr("data-parent");

	    var dataID = $(this).attr("data-guideid");
		$(".planner-guide").prop('checked', false);
		$(".planner-guide[data-guideid='"+dataID+"']").prop('checked', true);

		if (this.checked) {
			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.LangValue').html($li);
		} else {
			$('text:contains('+this.value+')', '.LangValue').remove();
		}
	    
	    if($(this).prop("checked")){
			$("#"+dataparent).prop("checked", true);
		}				

	    countAdditionalServices();	
	    setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);			    
	    
	});

	$(document).on("change", ".planner-transport", function(){
	    var dataparent = $(this).attr("data-parent");
		var dataID = $(this).attr("id");
		$(".planner-transport").prop('checked', false);
		$(".planner-transport[id='"+dataID+"']").prop('checked', true);

		if (this.checked) {
			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.TransportValue').html($li);
		} else {
			$('text:contains('+this.value+')', '.TransportValue').remove();
		}				

	    countAdditionalServices();	
	    setTimeout(function(){
    		updateDirections(google, directionsService, directionsDisplay);
    	}, 500);			    
	    
	});

	$(document).on("click", ".g-plan-hotels", function(){
		var checked = $(".TripCheckbox", this).prop("checked");
		if(checked){
			$(".planner-hotels").prop('checked', false);
			$(".hostelValue").html('');

			$(".TripCheckbox", this).prop("checked", false);
			$(".mobile-HotelsDropDown").val('');
			countAdditionalServices();
		}else{
			$(".g-plan-dropdown-toggle").toggleClass("open");
		}

		setTimeout(function(){
			updateDirections(google, directionsService, directionsDisplay);
		}, 500);

		return false;
	});

	$(document).on("click", ".g-plan-cuisune", function(){
		var checked = $(".TripCheckbox", this).prop("checked");
		if(checked){
			$(".planner-cuisune").prop('checked', false);
			$(".CuisineValue").html('');

			$(".TripCheckbox", this).prop("checked", false);
			// $(".mobile-CuisineDropDown").val('');
			countAdditionalServices();
		}else{
			$(".g-plan-dropdown-toggle2").toggleClass("open");
		}

		setTimeout(function(){
			updateDirections(google, directionsService, directionsDisplay);
		}, 500);

		return false;
	});

	$(document).on("click", ".g-plan-guide", function(){ 
		var checked = $(".TripCheckbox", this).prop("checked");
		if(checked){
			$(".planner-guide").prop('checked', false);
			$(".LangValue").html('');

			$(".TripCheckbox", this).prop("checked", false);
			$(".mobile-LanguageDropDown").val('');
			countAdditionalServices();
		}else{
			$(".g-plan-dropdown-toggle3").toggleClass("open");
		}

		setTimeout(function(){
			updateDirections(google, directionsService, directionsDisplay);
		}, 500);
		return false;
	});

	$(document).on("click", ".g-plan-transport", function(){
		$(".g-plan-dropdown-toggle4").toggleClass("open"); 
		return false;
	});
} 


function updateDirections(google, directionsService, directionsDisplay)
{
	$(".TripCheckbox").attr("disabled", "disabled");
	$(".theAllDatepicker").attr("disabled", "disabled");
	$(".input-number").attr("disabled", "disabled");
	$(".planner-childrenunder").attr("disabled", "disabled");
	$(".planner-children").attr("disabled", "disabled");
	$(".input-group-btn button").attr("disabled", "disabled");

	$(".SidebarDaysList").html("...");
	$(".SumCount span.gelprice").html("...");
	
	var hotelPrice = (typeof $("#plantripform input[name='hotels[]']").attr("data-price") !== "undefined") ? parseInt($("#plantripform input[name='hotels[]']").attr("data-price")) : 0;
	var cuisune = 0;
	$("#plantripform input[name='cuisune[]']").each(function(){
		let id = $(this).val();
		let price = parseInt($(this).attr("data-price"));
		cuisune += parseInt(price);
	});


	var guide = (typeof $("#plantripform input[name='guide[]']").attr("data-price") !== "undefined") ? parseInt($("#plantripform input[name='guide[]']").attr("data-price")) : 0;

	var guests = parseInt($("#quant2").val());
	var children = parseInt($(".planner-children").val());
	var childrenunder = parseInt($(".planner-childrenunder").val());

	var addSum = parseInt(hotelPrice + cuisune + guide);
	var price_sum_converted = 0;

	var waypts = [];
	var checked_places = [];
	$("#plantripform input").each(function(){
		if(typeof $(this).attr("data-map") !== "undefined"){

			var m = $(this).attr("data-map").split(",");
			var c = $(this).attr("data-cates");
			var t = $(this).attr("data-title");
			waypts.push({
		        location: new google.maps.LatLng(m[0],m[1]),
		        stopover: true
		    });
		    checked_places.push({
		    	typeID:c,
		    	title:t
		    });
		}
	});


	var map_coordinates = $(".LocationDropDown2 .TripCheckbox:checked").attr("data-map_coordinates");
	var coo = map_coordinates.split(", "); 
	var start = new google.maps.LatLng(coo[0], coo[1]);
    var end = (typeof waypts[waypts.length-1] !== "undefined") ? waypts[waypts.length-1].location : '';
    waypts.pop();

    if(end==""){
		directionsDisplay.setMap(null);

		$(".TripCheckbox").attr("disabled", false);
		$(".theAllDatepicker").attr("disabled", false);
		$(".input-number").attr("disabled", false);
		$(".planner-childrenunder").attr("disabled", false);
		$(".planner-children").attr("disabled", false);
		$(".input-group-btn button").attr("disabled", false);

		return false;
	}

    var request = {
		origin: start, 
		destination: end,
        travelMode: 'DRIVING',
        waypoints: waypts,
	    optimizeWaypoints: true
    };



	
	directionsService.route(request, function(response, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(response);

			var km = 0;
			var hours = 0;
			var TotalPrice = 0;
			var Day = 1;
			var lastDay = 0;
			var totalkm = 0;
			var kmprice = 0;

			$(".SidebarDaysList").html('');
			$(".SumCount span.gelprice").text(TotalPrice);

			for(var counter = 0; counter <= (response.routes[0].legs.length-1); counter++){
				totalkm += parseFloat(response.routes[0].legs[counter].distance.value);
			}
			totalkm = totalkm / 1000;
			$("#totalkm").val(totalkm);

			var kmlimit_sedan = parseInt($("#tra125").attr("data-kmlimit")); 
			var kmlimit_minivan = parseInt($("#tra126").attr("data-kmlimit"));
			var kmlimit_bus = parseInt($("#tra127").attr("data-kmlimit"));
			

			var child_price = 0;
			var toursArray = new Array();
			for(var counter = 0; counter <= (response.routes[0].legs.length-1); counter++){
				var kmx = parseFloat(response.routes[0].legs[counter].distance.value);
				hours += (((response.routes[0].legs[counter].duration.value/60)/60)*2)+1;
				km = parseFloat(kmx/1000);
				
				if($("#tra125").prop("checked") && totalkm<kmlimit_sedan){
					kmprice = parseFloat($("#tra125").attr("data-kiloprice-down"));
					if((guests+children+childrenunder)>3){
						let howManyCars = Math.ceil((guests+children+childrenunder) / 3);
						kmprice = parseFloat(kmprice * howManyCars);
					}
				}else if($("#tra125").prop("checked") && totalkm>=kmlimit_sedan){
					kmprice = parseFloat($("#tra125").attr("data-kiloprice-up"));
					if((guests+children+childrenunder)>3){
						let howManyCars = Math.ceil((guests+children+childrenunder) / 3);
						kmprice = parseFloat(kmprice * howManyCars);
					}
				}else if($("#tra126").prop("checked") && totalkm<kmlimit_minivan){
					kmprice = parseFloat($("#tra126").attr("data-kiloprice-down"));
					if((guests+children+childrenunder)>6){
						let howManyMinivan = Math.ceil((guests+children+childrenunder) / 6);
						kmprice = parseFloat(kmprice * howManyMinivan);
					}
				}else if($("#tra126").prop("checked") && totalkm>=kmlimit_minivan){
					kmprice = parseFloat($("#tra126").attr("data-kiloprice-up"));
					if((guests+children+childrenunder)>6){
						let howManyMinivan = Math.ceil((guests+children+childrenunder) / 6);
						kmprice = parseFloat(kmprice * howManyMinivan);
					}
				}else if($("#tra127").prop("checked") && totalkm<kmlimit_bus){
					kmprice = parseFloat($("#tra127").attr("data-kiloprice-down"));
					if((guests+children+childrenunder)>12){
						let howManyBus = Math.ceil((guests+children+childrenunder) / 12);
						kmprice = parseFloat(kmprice * howManyBus);
					}
				}else if($("#tra127").prop("checked") && totalkm>=kmlimit_bus){
					kmprice = parseFloat($("#tra127").attr("data-kiloprice-up"));
					if((guests+children+childrenunder)>12){
						let howManyBus = Math.ceil((guests+children+childrenunder) / 12);
						kmprice = parseFloat(kmprice * howManyBus);
					}
				}

				
				var price = parseFloat(km*kmprice);

				if(Math.ceil(hours/14) <= 1){
                	Day = 1;
            	}else{
                	Day = Math.ceil(hours/14);
            	}

            	let needday = parseInt(Day)-1;
            	
            	var theAllDatepicker = $("#startDatePicker").val();
            	var theAllDatepickerMobile = $("#mobile-startdate").val();
            	let startDate = new Date(theAllDatepicker);                  
            	let startDateMobile = new Date(theAllDatepickerMobile);                  
				let tour_dayes_times = needday * 86400000;

				let tour_finish = startDate.getTime() + tour_dayes_times;
				let tour_finishMobile = startDateMobile.getTime() + tour_dayes_times;

				var setTodate = new Date(new Date().setTime(tour_finish));
				var setTodateMobile = new Date(new Date().setTime(tour_finishMobile));
				$(".theAllDatepicker2").val(setTodate.yyyymmdd());
				$("#mobile-enddate").val(setTodateMobile.yyyymmdd());

				$("#needday").val(needday);							
				
				var dayName = "day"+Day;
				
				var TourList = {};
				TourList[dayName] = {
					title:checked_places[counter].title,
					price:price, //child_price_
					day:Day
				};				
				toursArray.push(TourList);
			}



			// TotalPrice = totalkm * kmprice;
			
			var d = "";
			for(var i = 0; i<parseInt(Day); i++){
				var active = (i==0) ? " active" : "";
				d += "<div class=\"Item"+active+"\">";
				d += "<div class=\"Day\"><span>"+(i+1)+"</span>"+ VAR_DAY +"</div>";

				for(var i2 = 0; i2<=toursArray.length; i2++){
					if(typeof toursArray[i2] !== "undefined" && typeof toursArray[i2]["day"+(i+1)] !== "undefined"){
						var datax = toursArray[i2]["day"+(i+1)];

						// var fixed2FloatPoints = parseInt( * 10) / 10;
						d += "<li><label>"+datax.title+"</label> <span>"+parseFloat(datax.price).toFixed(2)+"<i>A</i></span></li>";
						price_sum_converted += parseFloat(datax.price);
					}
					
				}

				d += "</div>";
			}
			$(".SidebarDaysList").html(d);
		}

		price_sum_converted = parseFloat(price_sum_converted + (addSum));

		$(".SumCount span.gelprice").html(parseFloat(price_sum_converted).toFixed(2)+"<i>A</i>");


		$(".TripCheckbox").attr("disabled", false);
		$(".theAllDatepicker").attr("disabled", false);
		$(".input-number").attr("disabled", false);
		$(".planner-childrenunder").attr("disabled", false);
		$(".planner-children").attr("disabled", false);
		$(".input-group-btn button").attr("disabled", false);

		return true;
		
	});
	
}


/*
mobile change start
*/
$("#mobile-regions").change(function(){
    updateDataMobile();
});

$(document).on("click", ".g-hovertext", function(){
    $(this).css("z-index", "1");
});


$("#mobile-place").change(function(){
	var id = $(this).val();
	$(".LocationDropDown2 .Item #List"+id).trigger("click");
})

$('.LocationDropDown1 input').change(function() {
	if (this.checked) {
		$li = $(' <text> </text> ');
		$li.text(this.value);
		$('.InpueValue1').append($li);
	}
	else {
		$('text:contains('+this.value+')', '.InpueValue1').remove();
	}

	updateData();
});

$('.LocationDropDown2 input').change(function() {
    $(".InpueValue2 text").remove();
    $(".LocationDropDown2 input").prop('checked', false);
    this.checked = true;
  if (this.checked) {
    $li = $(' <text> </text> ');
    $li.text(this.value);
    $('.InpueValue2').append($li);
  }
  else {
    $('text:contains('+this.value+')', '.InpueValue2').remove();
  }
});


$('.cuisune-mobile-checkbox').change(function() {
	var cuisuneid = parseInt($(this).attr("data-cuisuneid"));
	var parentCheck = false;
	
	if($(this).prop("checked")){
		$("#Cuisine"+cuisuneid).prop("checked", true);
	}else{
		$("#Cuisine"+cuisuneid).prop("checked", false);
	}

	$("#Cuisine"+cuisuneid).trigger("change");

	$('.cuisune-mobile-checkbox').each(function(){
		if($(this).prop("checked")){
			parentCheck = true;
		}
	});

	$("#Cuisine").prop("checked", parentCheck);
});


$('.guestsN-mobile').change(function() {
	var id = parseInt($(this).attr("data-id"));
	var val = $(this).val();
	$(".guestsN[data-id='"+id+"']").val(val);
	$("#Cuisine"+id).trigger("change");
});

$('.TransporDropDown input').change(function() {
  if (this.checked) {
    $li = $(' <text> </text> ');
    $li.text(this.value);
    $('.TransportValue').append($li);
  }
  else {
    $('text:contains('+this.value+')', '.TransportValue').remove();
  }
});