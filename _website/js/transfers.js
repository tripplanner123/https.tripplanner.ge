window.mobileAndTabletcheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
};

var map2 = "";
function doublemap(){
	var myLatLng = {lat: 41.705171, lng: 44.876335}; 
	map2 = new google.maps.Map(document.getElementById('SidebarSmallMap2'), {
        zoom: 6,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var directionsService = new google.maps.DirectionsService();
	var directionsDisplay = new google.maps.DirectionsRenderer();

	directionsDisplay.setMap(map2);
	directionsDisplay.setOptions({ 
		polylineOptions: {
			strokeColor: "#12693b"
		}, 
		suppressMarkers: true 
	});

	/* doubleway start */
	$('.double-TransporDropDown input').change(function() {
		$('#SearchFilterItem .dropdown-toggle').dropdown('toggle');
		if (this.checked) {
			$('.double-TransporDropDown input').prop('checked', false);
			$(this).prop('checked', true);

			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.double-TransportValue').html($li);
		}else{
			$('.double-TransporDropDown input').prop('checked', false);
			$('text:contains('+this.value+')', '.double-TransportValue').remove();
		}

		//updateMapDirDouble
		if($('.LocationDropDown4 input:checkbox:checked').length > 0 && $(".LocationDropDown5 input:checkbox:checked").length > 0){
			var start = $('.LocationDropDown4 input:checked').attr("data-map").split(", ");
			var end = $(".LocationDropDown5 input:checked").attr('data-map').split(", ");
			var waypts = [];
			waypts.push({
		        location: new google.maps.LatLng(start[0], start[1]),
		        stopover: true
		    });

		    waypts.push({
		        location: new google.maps.LatLng(end[0], end[1]),
		        stopover: true
		    });
		 	updateMapDirDouble(waypts, directionsService, google, directionsDisplay, false);
		}
	});


	$('.LocationDropDown4 input').change(function() {
		var id = $(this).attr("data-id");
		$(".LocationDropDown5 .TripCheckbox").removeAttr("disabled");
		$("#List5"+id).attr("disabled", "disabled");
		$('#LocationDropDown4 .dropdown-toggle').dropdown('toggle');
		if (this.checked) {
			$('.LocationDropDown4 input').prop('checked', false);
			$(this).prop('checked', true);

			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.InpueValue4').html($li);
		}else{
			$('.LocationDropDown4 input').prop('checked', false);
			$('text:contains('+this.value+')', '.InpueValue4').remove();
		}

		//updateMapDirDouble
		if($('.LocationDropDown4 input:checkbox:checked').length > 0 && $(".LocationDropDown5 input:checkbox:checked").length > 0){
			var start = $('.LocationDropDown4 input:checked').attr("data-map").split(", ");
			var end = $(".LocationDropDown5 input:checked").attr('data-map').split(", ");
			var waypts = [];
			waypts.push({
		        location: new google.maps.LatLng(start[0], start[1]),
		        stopover: true
		    });

		    waypts.push({
		        location: new google.maps.LatLng(end[0], end[1]),
		        stopover: true
		    });
		 	updateMapDirDouble(waypts, directionsService, google, directionsDisplay, false);
		}
	});

	$('.LocationDropDown5 input').change(function() {
		var id = $(this).attr("data-id");
		$(".LocationDropDown4 .TripCheckbox").removeAttr("disabled");
		$("#List4"+id).attr("disabled", "disabled");
		$('#LocationDropDown5 .dropdown-toggle').dropdown('toggle');
		if (this.checked) {
			$('.LocationDropDown5 input').prop('checked', false);
			$(this).prop('checked', true);

			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.InpueValue5').html($li);
		}else{
			$('.LocationDropDown5 input').prop('checked', false);
			$('text:contains('+this.value+')', '.InpueValue5').remove();
		}

		//updateMapDirDouble
		if($('.LocationDropDown4 input:checkbox:checked').length > 0 && $(".LocationDropDown5 input:checkbox:checked").length > 0){
			var start = $('.LocationDropDown4 input:checked').attr("data-map").split(", ");
			var end = $(".LocationDropDown5 input:checked").attr('data-map').split(", ");
			var waypts = [];
			waypts.push({
		        location: new google.maps.LatLng(start[0], start[1]),
		        stopover: true
		    });

		    waypts.push({
		        location: new google.maps.LatLng(end[0], end[1]),
		        stopover: true
		    });
		 	updateMapDirDouble(waypts, directionsService, google, directionsDisplay, false);
		}
	});

	/* double mobile start */
	$("#mobile-startingPlace2").change(function(){
		var val = $(this).val();
		$("#mobile-endPlace2 option").prop("disabled", false);
		$("#mobile-endPlace2 option[value='']").prop("disabled", true);
		$("#mobile-endPlace2 option[value='"+val+"']").prop("disabled", true);

		if(
			$("#mobile-startingPlace2 option:selected").attr("data-map") !== null && 
			$("#mobile-endPlace2 option:selected").attr("data-map") !== null &&
			typeof $("#mobile-startingPlace2 option:selected").attr("data-map") !== "undefined" && 
			typeof $("#mobile-endPlace2 option:selected").attr("data-map") !== "undefined"
		){
			var startingPlace = $("#mobile-startingPlace2 option:selected").attr("data-map").split(", ");
			var endPlace = $("#mobile-endPlace2 option:selected").attr("data-map").split(", ");

			var waypts = [];
			waypts.push({
		        location: new google.maps.LatLng(startingPlace[0], startingPlace[1]),
		        stopover: true
		    });

		    waypts.push({
		        location: new google.maps.LatLng(endPlace[0], endPlace[1]),
		        stopover: true
		    });
		 	updateMapDirDouble(waypts, directionsService, google, directionsDisplay, true);
	 	}
	});

	$("#mobile-endPlace2").change(function(){
		var val = $(this).val();
		$("#mobile-startingPlace2 option").prop("disabled", false);
		$("#mobile-startingPlace2 option[value='']").prop("disabled", true);
		$("#mobile-startingPlace2 option[value='"+val+"']").prop("disabled", true);

		if(
			$("#mobile-startingPlace2 option:selected").attr("data-map") !== null && 
			$("#mobile-endPlace2 option:selected").attr("data-map") !== null &&
			typeof $("#mobile-startingPlace2 option:selected").attr("data-map") !== "undefined" && 
			typeof $("#mobile-endPlace2 option:selected").attr("data-map") !== "undefined"
		){
			var startingPlace = $("#mobile-startingPlace2 option:selected").attr("data-map").split(", ");
			var endPlace = $("#mobile-endPlace2 option:selected").attr("data-map").split(", ");

			var waypts = [];
			waypts.push({
		        location: new google.maps.LatLng(startingPlace[0], startingPlace[1]),
		        stopover: true
		    });

		    waypts.push({
		        location: new google.maps.LatLng(endPlace[0], endPlace[1]),
		        stopover: true
		    });
		 	updateMapDirDouble(waypts, directionsService, google, directionsDisplay, true);
	 	}
	});
}

var map = "";
function initMap() {
	var myLatLng = {lat: 41.705171, lng: 44.876335};    
    map = new google.maps.Map(document.getElementById('SidebarSmallMap'), {
        zoom: 6,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var directionsService = new google.maps.DirectionsService();
	var directionsDisplay = new google.maps.DirectionsRenderer();

	directionsDisplay.setMap(map);
	directionsDisplay.setOptions({ 
		polylineOptions: {
			strokeColor: "#12693b"
		}, 
		suppressMarkers: true 
	});

	/*mobile start*/
	$("#mobile-startingPlace").change(function(){
		var val = $(this).val();
		$("#mobile-endPlace option").prop("disabled", false);
		$("#mobile-endPlace option[value='']").prop("disabled", true);
		$("#mobile-endPlace option[value='"+val+"']").prop("disabled", true);
		
		if(
			$("#mobile-startingPlace option:selected").attr("data-map") !== null && 
			$("#mobile-endPlace option:selected").attr("data-map") !== null &&
			typeof $("#mobile-startingPlace option:selected").attr("data-map") !== "undefined" && 
			typeof $("#mobile-endPlace option:selected").attr("data-map") !== "undefined"
		){
			var startingPlace = $("#mobile-startingPlace option:selected").attr("data-map").split(", ");
			var endPlace = $("#mobile-endPlace option:selected").attr("data-map").split(", ");

			var waypts = [];
			waypts.push({
		        location: new google.maps.LatLng(startingPlace[0], startingPlace[1]),
		        stopover: true
		    });

		    waypts.push({
		        location: new google.maps.LatLng(endPlace[0], endPlace[1]),
		        stopover: true
		    });
		 	updateMapDir(waypts, directionsService, google, directionsDisplay, true);
	 	}
	});

	$("#mobile-endPlace").change(function(){
		var val = $(this).val();
		$("#mobile-startingPlace option").prop("disabled", false);
		$("#mobile-startingPlace option[value='']").prop("disabled", true);
		$("#mobile-startingPlace option[value='"+val+"']").prop("disabled", true);

		if(
			$("#mobile-startingPlace option:selected").attr("data-map") !== null && 
			$("#mobile-endPlace option:selected").attr("data-map") !== null &&
			typeof $("#mobile-startingPlace option:selected").attr("data-map") !== "undefined" && 
			typeof $("#mobile-endPlace option:selected").attr("data-map") !== "undefined"
		){
			var startingPlace = $("#mobile-startingPlace option:selected").attr("data-map").split(", ");
			var endPlace = $("#mobile-endPlace option:selected").attr("data-map").split(", ");

			var waypts = [];
			waypts.push({
		        location: new google.maps.LatLng(startingPlace[0], startingPlace[1]),
		        stopover: true
		    });

		    waypts.push({
		        location: new google.maps.LatLng(endPlace[0], endPlace[1]),
		        stopover: true
		    });
		 	updateMapDir(waypts, directionsService, google, directionsDisplay, true);
	 	}
	});
	/*mobile end*/


	$('.TransporDropDown input').change(function() {
		$('#TransporDropDown .dropdown-toggle').dropdown('toggle');
		if (this.checked) {
			$('.TransporDropDown input').prop('checked', false);
			$(this).prop('checked', true);

			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.TransportValue').html($li);
		}else{
			$('.TransporDropDown input').prop('checked', false);
			$('text:contains('+this.value+')', '.TransportValue').remove();
		}

		if($('.LocationDropDown2 input:checkbox:checked').length > 0 && $(".LocationDropDown3 input:checkbox:checked").length > 0){
			var start = $('.LocationDropDown2 input:checked').attr("data-map").split(", ");
			var end = $(".LocationDropDown3 input:checked").attr('data-map').split(",");
			var waypts = [];
			waypts.push({
		        location: new google.maps.LatLng(start[0], start[1]),
		        stopover: true
		    });

		    waypts.push({
		        location: new google.maps.LatLng(end[0], end[1]),
		        stopover: true
		    });
		 	updateMapDir(waypts, directionsService, google, directionsDisplay, false);
		}
	});

	$('.LocationDropDown2 input').change(function() {
		var id = $(this).attr("data-id");
		$(".LocationDropDown3 .TripCheckbox").removeAttr("disabled");
		$("#List3"+id).attr("disabled", "disabled");
		$('.SearchFilterItem .dropdown-toggle').dropdown('toggle');
		if (this.checked) {
			$('.LocationDropDown2 input').prop('checked', false);
			$(this).prop('checked', true);

			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.InpueValue2').html($li);
		}else{
			$('.LocationDropDown2 input').prop('checked', false);
			$('text:contains('+this.value+')', '.InpueValue2').remove();
		}

		if($('.LocationDropDown2 input:checkbox:checked').length > 0 && $(".LocationDropDown3 input:checkbox:checked").length > 0){
			var start = $('.LocationDropDown2 input:checked').attr("data-map").split(", ");
			var end = $(".LocationDropDown3 input:checked").attr('data-map').split(", ");
			var waypts = [];
			waypts.push({
		        location: new google.maps.LatLng(start[0], start[1]),
		        stopover: true
		    });

		    waypts.push({
		        location: new google.maps.LatLng(end[0], end[1]),
		        stopover: true
		    });
		 	updateMapDir(waypts, directionsService, google, directionsDisplay, false);
		}
	});

	$('.LocationDropDown3 input').change(function() {
		var id = $(this).attr("data-id");
		$(".LocationDropDown2 .TripCheckbox").removeAttr("disabled");
		$("#List"+id).attr("disabled", "disabled");
		$('.SearchFilterItem .dropdown-toggle').dropdown('toggle');
		if (this.checked) {
			$('.LocationDropDown3 input').prop('checked', false);
			$(this).prop('checked', true);

			$li = $(' <text> </text> ');
			$li.text(this.value);
			$('.InpueValue3').html($li);
		}else{
			$('.LocationDropDown3 input').prop('checked', false);
			$('text:contains('+this.value+')', '.InpueValue3').remove();
		}	

		if($('.LocationDropDown2 input:checkbox:checked').length > 0 && $(".LocationDropDown3 input:checkbox:checked").length > 0){
			var start = $('.LocationDropDown2 input:checked').attr("data-map").split(", ");
			var end = $(".LocationDropDown3 input:checked").attr('data-map').split(", ");
			var waypts = [];
			waypts.push({
		        location: new google.maps.LatLng(start[0], start[1]),
		        stopover: true
		    });

		    waypts.push({
		        location: new google.maps.LatLng(end[0], end[1]),
		        stopover: true
		    });
		 	updateMapDir(waypts, directionsService, google, directionsDisplay, false);
		}
	});


	$('.startdatetrans').change(function() {
		if($('.LocationDropDown2 input:checkbox:checked').length > 0 && $(".LocationDropDown3 input:checkbox:checked").length > 0){
			if(mobileAndTabletcheck()){
				countPriceTransportMobileDouble();
			}else{
				countPriceTransportDouble();
			}
		}
	});

	$('.double-startdatetrans').change(function() {
		if($('.LocationDropDown2 input:checkbox:checked').length > 0 && $(".LocationDropDown3 input:checkbox:checked").length > 0){
			if(mobileAndTabletcheck()){
				countPriceTransportMobileDouble();
			}else{
				countPriceTransportDouble();
			}
		}
	});
}

/* double way function start */
function updateMapDirDouble(waypts, directionsService, google, directionsDisplay, mobile){
	var start = waypts[0];	
    var end = waypts[1];	

    var request = {
		origin: start.location, 
		destination: waypts[waypts.length-1].location,
        travelMode: 'DRIVING',
        waypoints: waypts,
	    optimizeWaypoints: true
    };

    directionsDisplay.setOptions({ 
		polylineOptions: {
			strokeColor: "#b48d27"
		}, 
		suppressMarkers: true 
	});

    directionsService.route(request, function(response, status) {
    	if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(response);
			var km = 0;
			for(var i=0; i<response.routes[0].legs.length; i++){
				km += parseInt(response.routes[0].legs[i].distance.value) / 1000;
			}
			
			$("#double-km").val(parseInt(km));

			var CSRF_token = $('meta[name=CSRF_token]').attr("value");

            $.ajax({
                type: "POST",
                url: "https://tripplanner.ge/en/?ajax=true",
                data: { 
                    type:"mapdir_", 
                    tk:"*(78..Ui"+km+"[^%$54512251*76]", 
                    xk:status, 
                    dv:parseFloat(response.routes[0].legs[0].distance.value)*53,
                    token:CSRF_token           
                } 
            }).done(function( msg ) {
                
            });

			if(mobile){
				countPriceTransportMobileDouble();
			}else{
				countPriceTransportDouble();
			}
		}
    });
}
/* double way function end */

function updateMapDir(waypts, directionsService, google, directionsDisplay, mobile){
	var start = waypts[0];	
    var end = waypts[1];

    var request = {
		origin: start.location, 
		destination: end.location,
        travelMode: 'DRIVING',
        waypoints: waypts,
	    optimizeWaypoints: true
    };

    directionsService.route(request, function(response, status) {
    	if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(response);
			var km = 0;
			for(var i=0; i<response.routes[0].legs.length; i++){
				km += parseInt(response.routes[0].legs[i].distance.value) / 1000;
			}
			$("#km").val(parseInt(km));

			var CSRF_token = $('meta[name=CSRF_token]').attr("value");

            $.ajax({
                type: "POST",
                url: "https://tripplanner.ge/en/?ajax=true",
                data: { 
                    type:"mapdir", 
                    tk:"*(78..Ui"+km+"[^%$54512251*76]", 
                    xk:status, 
                    dv:parseFloat(response.routes[0].legs[0].distance.value)*153,
                    token:CSRF_token           
                } 
            }).done(function( msg ) {
                
            });

			if(mobile){
				countPriceTransportMobile();
			}else{
				countPriceTransport();
			}
		}
    });
}

function countPriceTransport(){
	var km = parseFloat($("#km").val());
	var guests = parseInt($("#guest-number").val());
	var children = parseInt($("#children-number").val());
	var underchildren = parseInt($("#children-under").val());
	var transport_price_per_km = 0;

	var kmlimit_sedan = parseInt($("#ListTra125").attr("data-kmlimit"));
	var kmlimit_minivan = parseInt($("#ListTra126").attr("data-kmlimit"));
	var kmlimit_bus = parseInt($("#ListTra127").attr("data-kmlimit"));

	var totalCrow = parseInt(guests) + parseInt(children) + parseInt(underchildren);

	/* New Calculation START */
	var nv_transport_object = transfersPrices.sedan;
	if($("#ListTra125").prop("checked")){//SEDAN
		nv_transport_object = transfersPrices.sedan;
	}else if($("#ListTra126").prop("checked")){//MINIVAN
		nv_transport_object = transfersPrices.minivan;
	}else if($("#ListTra127").prop("checked")){//MINIBUS
		nv_transport_object = transfersPrices.minibus;
	}else if($("#ListTra220").prop("checked")){//BUS
		nv_transport_object = transfersPrices.bus;
	}
	
	if(km<50){//0-49
		transport_price_per_km = nv_transport_object.p_transfer_0_50;
	}else if(km>=50 && km<100){//50-99
		transport_price_per_km = nv_transport_object.p_transfer_50_100;
	}else if(km>=100 && km<150){//100-149
		transport_price_per_km = nv_transport_object.p_transfer_100_150;
	}else if(km>=150 && km<200){//150-199
		transport_price_per_km = nv_transport_object.p_transfer_150_200;
	}else if(km>=200 && km<250){//200-249
		transport_price_per_km = nv_transport_object.p_transfer_200_250;
	}else if(km>=250 && km<300){//250-299
		transport_price_per_km = nv_transport_object.p_transfer_250_300;
	}else if(km>=300 && km<350){//300-349
		transport_price_per_km = nv_transport_object.p_transfer_300_350;
	}else if(km>=350 && km<400){//350-399
		transport_price_per_km = nv_transport_object.p_transfer_350_400;
	}else if(km>=400){//400+
		transport_price_per_km = nv_transport_object.p_transfer_400_plus;
	}

	if(totalCrow>nv_transport_object.p_transfer_max_crowed){
		let howManyCars = Math.ceil(totalCrow / nv_transport_object.p_transfer_max_crowed);
		transport_price_per_km = parseFloat(transport_price_per_km * howManyCars);
	}
	/* New Calculation END */
	
	let dataplus = $(".LocationDropDown2 .Item .TripCheckbox:checked").attr("data-plus");
	var ten = (typeof dataplus !== "undefined") ? parseInt(dataplus) : 0;
	ten*=10;
	let dataplus2 = $(".LocationDropDown3 .Item .TripCheckbox:checked").attr("data-plus");
	var ten2 = (typeof dataplus2 !== "undefined") ? parseInt(dataplus2) : 0;
	ten2*=10;

	ten = ten + ten2;

	
	// var cur = "<i>A</i>";
	// var cur_exchange = 1;

	var totalprice = km*transport_price_per_km+ten;
	/* ADD INCOME PRERCENT start*/
	var income_proc = parseFloat(nv_transport_object.income_proc);
	totalprice = totalprice + (totalprice * income_proc / 100); 
	/* ADD INCOME PRERCENT end*/

	$("#totalprice").attr("data-gelprice", (parseFloat(totalprice).toFixed(0) || 0));

	var usd = parseFloat($("#g-cur-exchange-usd").val());
    var eur = parseFloat($("#g-cur-exchange-eur").val());

    var totalThePrice___;
    var cur;
    if($("#g-cur__").val()=="usd"){
        totalThePrice___ = Math.round(totalprice / usd).toFixed(0); 
        cur = "$";
    }else if($("#g-cur__").val()=="eur"){
        totalThePrice___ = Math.round(totalprice / eur).toFixed(0); 
        cur = "&euro;";
    }else{
        totalThePrice___ = totalprice.toFixed(0);
        cur = "<i>A</i>";
    }

	$("#totalprice").html( (totalThePrice___ || 0)+cur);

	$(".QuantityButton").attr("disabled", false);
}

function countPriceTransportDouble(){
	var km = parseInt($("#double-km").val());
	var guests = parseInt($("#double-guest-number").val());
	var children = parseInt($("#double-children-number").val());
	var underchildren = parseInt($("#double-children-under-number").val());
	var transport_price_per_km = 0;

	var kmlimit_sedan = parseInt($("#double-ListTra125").attr("data-kmlimit"));
	var kmlimit_minivan = parseInt($("#double-ListTra126").attr("data-kmlimit"));
	var kmlimit_bus = parseInt($("#double-ListTra127").attr("data-kmlimit"));

	var totalCrow = parseInt(guests) + parseInt(children) + parseInt(underchildren);

	/* New Calculation START */
	var nv_transport_object = transfersPrices.sedan;
	if($("#double-ListTra125").prop("checked")){//SEDAN
		nv_transport_object = transfersPrices.sedan;
	}else if($("#double-ListTra126").prop("checked")){//MINIVAN
		nv_transport_object = transfersPrices.minivan;
	}else if($("#double-ListTra127").prop("checked")){//MINIBUS
		nv_transport_object = transfersPrices.minibus;
	}else if($("#double-ListTra220").prop("checked")){//BUS
		nv_transport_object = transfersPrices.bus;
	}
	
	if(km<50){//0-49
		transport_price_per_km = nv_transport_object.p_transfer_0_50;
	}else if(km>=50 && km<100){//50-99
		transport_price_per_km = nv_transport_object.p_transfer_50_100;
	}else if(km>=100 && km<150){//100-149
		transport_price_per_km = nv_transport_object.p_transfer_100_150;
	}else if(km>=150 && km<200){//150-199
		transport_price_per_km = nv_transport_object.p_transfer_150_200;
	}else if(km>=200 && km<250){//200-249
		transport_price_per_km = nv_transport_object.p_transfer_200_250;
	}else if(km>=250 && km<300){//250-299
		transport_price_per_km = nv_transport_object.p_transfer_250_300;
	}else if(km>=300 && km<350){//300-349
		transport_price_per_km = nv_transport_object.p_transfer_300_350;
	}else if(km>=350 && km<400){//350-399
		transport_price_per_km = nv_transport_object.p_transfer_350_400;
	}else if(km>=400){//400+
		transport_price_per_km = nv_transport_object.p_transfer_400_plus;
	}

	if(totalCrow>nv_transport_object.p_transfer_max_crowed){
		let howManyCars = Math.ceil(totalCrow / nv_transport_object.p_transfer_max_crowed);
		transport_price_per_km = parseFloat(transport_price_per_km * howManyCars);
	}


	var samewaydiscount = nv_transport_object.samewaydiscount;
	var firstFromPlace = parseInt($(".LocationDropDown2 .TripCheckbox:checked").attr("data-id"));
	var secondFromPlace = parseInt($(".LocationDropDown3 .TripCheckbox:checked").attr("data-id"));
	var thirdFromPlace = parseInt($(".LocationDropDown4 .TripCheckbox:checked").attr("data-id"));
	var fourFromPlace = parseInt($(".LocationDropDown5 .TripCheckbox:checked").attr("data-id"));
	var ex1 = $(".startdatetrans").val().split("-");
	var ex2 = $(".double-startdatetrans").val().split("-");

	var year = ex1[0];
	var month = (ex1[1].length<=1) ? "0"+ex1[1] : ex1[1];
	var day = (ex1[2].length<=1) ? "0"+ex1[2] : ex1[2];

	var year2 = ex2[0];
	var month2 = (ex2[1].length<=1) ? "0"+ex2[1] : ex2[1];
	var day2 = (ex2[2].length<=1) ? "0"+ex2[2] : ex2[2];

	var firstFullDate = year + "-" + month + "-" + day;
	var secondFullDate = year2 + "-" + month2 + "-" + day2;

	//same way back discount
	if(firstFromPlace==fourFromPlace && secondFromPlace==thirdFromPlace && firstFullDate==secondFullDate){
		transport_price_per_km = transport_price_per_km - ((transport_price_per_km*samewaydiscount) / 100);
	}
	/* New Calculation END */


	var ten = parseInt($(".LocationDropDown4 .Item .TripCheckbox:checked").attr("data-plus"));
	ten*=10;
	var ten2 = parseInt($(".LocationDropDown5 .Item .TripCheckbox:checked").attr("data-plus"));
	ten2*=10;

	ten = ten + ten2;
	
	var totalprice = km*transport_price_per_km+ten;

	/* ADD INCOME PRERCENT start*/
	var income_proc = parseFloat(nv_transport_object.income_proc);
	totalprice = totalprice + (totalprice * income_proc / 100); 
	/* ADD INCOME PRERCENT end*/

	totalprice = ( isNaN(totalprice) ) ? 0 : totalprice;
	$("#totalprice2").attr("data-gelprice", (parseFloat(totalprice).toFixed(0) || 0));

	var usd = parseFloat($("#g-cur-exchange-usd").val());
    var eur = parseFloat($("#g-cur-exchange-eur").val());

    var totalThePrice___;
    var cur;
    if($("#g-cur__").val()=="usd"){
        totalThePrice___ = Math.round(totalprice / usd).toFixed(0); 
        cur = "$";
    }else if($("#g-cur__").val()=="eur"){
        totalThePrice___ = Math.round(totalprice / eur).toFixed(0); 
        cur = "&euro;";
    }else{
        totalThePrice___ = totalprice.toFixed(0);
        cur = "<i>A</i>";
    }

	$("#totalprice2").html( (totalThePrice___ || 0) +cur);
}

function changeTransport(num, mobile){
	var sedanMax = parseInt(transfersPrices.sedan.p_transfer_max_crowed);
	var vanMax = parseInt(transfersPrices.minivan.p_transfer_max_crowed);
	var miniBusMax = parseInt(transfersPrices.minibus.p_transfer_max_crowed);
	var busMax = parseInt(transfersPrices.bus.p_transfer_max_crowed);
	console.log(sedanMax + " " + num);
	
	if(mobile){
		if(num<=sedanMax){//<=3
			$("#mobile-transpor").val("125");
		}else if(num>=(sedanMax+1) && num<=vanMax){//>=4 && <=6
			$("#mobile-transpor").val("126");
		}else if(num>=(vanMax+1) && num<=miniBusMax){//>= 7 && <=15
			$("#mobile-transpor").val("127");
		}else if(num>=(miniBusMax+1)){//>= 16
			$("#mobile-transpor").val("220");
		}
	}else{
		if(num<=sedanMax){
			$("#mobile-transpor").val("125");
			$("#ListTra125").prop("checked", true).trigger("change");
		}else if(num>=(sedanMax+1) && num<=vanMax){
			$("#mobile-transpor").val("126");
			$("#ListTra126").prop("checked", true).trigger("change");
		}else if(num>=(vanMax+1) && num<=miniBusMax){
			$("#mobile-transpor").val("127");
			$("#ListTra127").prop("checked", true).trigger("change");
		}else if(num>=(miniBusMax+1) && $("#ListTra220:checked").length <= 0){
			$("#mobile-transpor").val("220");
			$("#ListTra220").prop("checked", true).trigger("change");
		}
	}
}

function doublechangeTransport(num, mobile){
	var sedanMax = transfersPrices.sedan.p_transfer_max_crowed;
	var vanMax = transfersPrices.minivan.p_transfer_max_crowed;
	var miniBusMax = transfersPrices.minibus.p_transfer_max_crowed;
	var busMax = transfersPrices.bus.p_transfer_max_crowed;

	if(mobile){
		if(num<=sedanMax){//<=3
			$("#double-mobile-transpor").val("125");		
		}else if(num>=(sedanMax+1) && num<=vanMax){//>=4 && <=6
			$("#double-mobile-transpor").val("126");
		}else if(num>=(vanMax+1) && num<=miniBusMax){//>= 7 && <=15
			$("#double-mobile-transpor").val("127");
		}else if(num>=(miniBusMax+1) ){//>= 16
			$("#double-mobile-transpor").val("220");
		}
	}else{
		if(num<=sedanMax && $("#double-ListTra125:checked").length <= 0){
			$("#double-ListTra125").trigger("click");		
		}else if(num>=(sedanMax+1) && num<=vanMax && $("#double-ListTra126:checked").length <= 0){
			$("#double-ListTra126").trigger("click");	
		}else if(num>=(vanMax+1) && $("#double-ListTra127:checked").length <= 0){
			$("#double-ListTra127").trigger("click");	
		}else if(num>=(miniBusMax+1) && $("#double-ListTra220:checked").length <= 0){
			$("#double-ListTra220").trigger("click");	
		}
	}
}

$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});

$('.input-number').change(function() {    
	var totalCrow = parseInt($('.input-number').val()) + parseInt($('#children-number').val()) + parseInt($('#children-under').val());
    changeTransport(totalCrow, false);
    countPriceTransport();
});

$('#children-number').change(function() {    
	var totalCrow = parseInt($('.input-number').val()) + parseInt($('#children-number').val()) + parseInt($('#children-under').val());
    changeTransport(totalCrow, false);
    countPriceTransport();
});

$('#children-under').change(function() {    
	var totalCrow = parseInt($('.input-number').val()) + parseInt($('#children-number').val()) + parseInt($('#children-under').val());
    changeTransport(totalCrow, false);
    countPriceTransport();
});

$('#double-guest-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});

$('#double-guest-number').change(function() {    
	var totalCrow = parseInt($('#double-guest-number').val()) + parseInt($('#double-children-number').val()) + parseInt($("#double-children-under-number").val());
    doublechangeTransport(totalCrow, false);
    countPriceTransportDouble();
});

$('#double-children-number').change(function() {    
    var totalCrow = parseInt($('#double-guest-number').val()) + parseInt($('#double-children-number').val()) + parseInt($("#double-children-under-number").val());
    doublechangeTransport(totalCrow, false);
    countPriceTransportDouble();
});

$('#double-children-under-number').change(function() {    
    var totalCrow = parseInt($('#double-guest-number').val()) + parseInt($('#double-children-number').val()) + parseInt($("#double-children-under-number").val());
    doublechangeTransport(totalCrow, false);
    countPriceTransportDouble();
});

$(document).on("click", ".doubleway", function(){
	var active = $(this).hasClass("active");
	if(active){
		$(".LocationDropDown4 input").trigger("change").prop("checked", false); 
		$(".LocationDropDown5 input").trigger("change").prop("checked", false); 

		countPriceTransportDouble();

		$(this).css({"background-image":"url('/_website/img/plus_icon.png')"});
		$(this).removeClass("active");
		$("#doubleway").hide();
		$(".doublemapbox").hide();		
	}else{
		setTimeout(function(){
			var firstV = $(".LocationDropDown2 .Item input:checked").val();
			var secondV = $(".LocationDropDown3 .Item input:checked").val();

			$(".LocationDropDown4 input[value='"+secondV+"']").prop("checked", true).trigger("change");
			$(".LocationDropDown5 input[value='"+firstV+"']").prop("checked", true).trigger("change");
			$("#LocationDropDown5").click();
		}, 2000);
		
		// var dateFirst = $(".startdatetrans").datepicker("getDate");
  //   	dateFirst.setDate(dateFirst.getDate()+1);          
  //   	var nextDay = dateFirst.getFullYear()+"-"+(dateFirst.getMonth()+1)+"-"+dateFirst.getDate();
  //   	$(".double-startdatetrans").val(nextDay);
		
		$(this).css({"background-image":"url('/_website/img/minus_icon.png')"});
		$(this).addClass("active");
		$("#doubleway").show();
		$(".doublemapbox").show();

	}
	doublemap();
});

$(document).on("click", ".mobile-doubleway", function(){
	var active = $(this).hasClass("active");
	if(active){
		$(this).css({"background-image":"url('/_website/img/plus_icon.png')"});
		$(this).removeClass("active");
		$("#mobile-doublewaybox").hide();
		$(".doublemapbox").hide();
	}else{
		setTimeout(function(){
			var firstV = $("#mobile-startingPlace").val();
			var secondV = $("#mobile-endPlace").val();

			$("#mobile-startingPlace2").val(secondV);
			$("#mobile-endPlace2").val(firstV).change();
		}, 2000);


		$(this).css({"background-image":"url('/_website/img/minus_icon.png')"});
		$(this).addClass("active");
		$("#mobile-doublewaybox").show();
		$(".doublemapbox").show();
	}
	doublemap();
});

$(document).on("change","#mobile-transpor", function(){
	countPriceTransportMobile();
});

$(document).on("change","#double-mobile-transpor", function(){
	countPriceTransportMobileDouble();
});

/* mobile */
function countPriceTransportMobile(){
	var km = parseInt($("#km").val());
	var guests = parseInt($("#mobile-guests").val());
	var children = parseInt($("#mobile-children").val());
	var underchildren = parseInt($("#mobile-children-under").val());
	var transport_price_per_km = 0;
	var vehicle = parseInt($("#mobile-transpor").val());

	var kmlimit = parseInt($("#mobile-transpor option:selected").attr("data-kmlimit"));

	var totalCrow = parseInt(guests) + parseInt(children) + parseInt(underchildren);


	/* New Calculation START */
	var nv_transport_object = transfersPrices.sedan;
	if(vehicle==125){//SEDAN
		nv_transport_object = transfersPrices.sedan;
	}else if(vehicle==126){//MINIVAN
		nv_transport_object = transfersPrices.minivan;
	}else if(vehicle==127){//MINIBUS
		nv_transport_object = transfersPrices.minibus;
	}else if(vehicle==220){//MINIBUS
		nv_transport_object = transfersPrices.bus;
	}
	
	if(km<50){//0-49
		transport_price_per_km = nv_transport_object.p_transfer_0_50;
	}else if(km>=50 && km<100){//50-99
		transport_price_per_km = nv_transport_object.p_transfer_50_100;
	}else if(km>=100 && km<150){//100-149
		transport_price_per_km = nv_transport_object.p_transfer_100_150;
	}else if(km>=150 && km<200){//150-199
		transport_price_per_km = nv_transport_object.p_transfer_150_200;
	}else if(km>=200 && km<250){//200-249
		transport_price_per_km = nv_transport_object.p_transfer_200_250;
	}else if(km>=250 && km<300){//250-299
		transport_price_per_km = nv_transport_object.p_transfer_250_300;
	}else if(km>=300 && km<350){//300-349
		transport_price_per_km = nv_transport_object.p_transfer_300_350;
	}else if(km>=350 && km<400){//350-399
		transport_price_per_km = nv_transport_object.p_transfer_350_400;
	}else if(km>=400){//400+
		transport_price_per_km = nv_transport_object.p_transfer_400_plus;
	}

	if(totalCrow>nv_transport_object.p_transfer_max_crowed){
		let howManyCars = Math.ceil(totalCrow / nv_transport_object.p_transfer_max_crowed);
		transport_price_per_km = parseFloat(transport_price_per_km * howManyCars);
	}
	/* New Calculation END */

	var ten = parseInt($("#mobile-startingPlace option:selected").attr("data-plus"));
	ten*=10;
	var ten2 = parseInt($("#mobile-endPlace option:selected").attr("data-plus"));
	ten2*=10;

	ten = ten + ten2;

	// var cur = "<i>A</i>";
	// var cur_exchange = 1;

	var totalprice = km*transport_price_per_km+ten;
	$("#totalprice").attr("data-gelprice", (parseInt(Math.round(totalprice)) || 0));

	var usd = parseFloat($("#g-cur-exchange-usd").val());
    var eur = parseFloat($("#g-cur-exchange-eur").val());

    var totalThePrice___;
    var cur;
    if($("#g-cur__").val()=="usd"){
        totalThePrice___ = Math.round(totalprice / usd).toFixed(0); 
        cur = "$";
    }else if($("#g-cur__").val()=="eur"){
        totalThePrice___ = Math.round(totalprice / eur).toFixed(0); 
        cur = "&euro;";
    }else{
        totalThePrice___ = totalprice.toFixed(0);
        cur = "<i>A</i>";
    }

	$("#totalprice").html((totalThePrice___ || 0)+cur);

	// setTimeout(function(){
 //        var currentCurrency__ = $("#currentCurrency__").val();
 //        if(currentCurrency__=="usd" || currentCurrency__=="eur"){
 //            $(".g-change-currency-v2 li[data-cur='"+currentCurrency__+"']").click();
 //        }
 //    }, 1000);
}

function countPriceTransportMobileDouble(){
	var km = parseInt($("#double-km").val());
	var transport_price_per_km = 0;
	var guests = parseInt($("#double-mobile-guests").val());
	var children = parseInt($("#double-mobile-child").val());
	var underchildren = parseInt($("#double-mobile-child-under").val());
	var vehicle = parseInt($("#double-mobile-transpor").val());
	var kmlimit = parseInt($("#double-mobile-transpor option:selected").attr("data-kmlimit"));

	var totalCrow = parseInt(guests) + parseInt(children) + parseInt(underchildren);

	/* New Calculation START */
	var nv_transport_object = transfersPrices.sedan;
	if(vehicle==125){//SEDAN
		nv_transport_object = transfersPrices.sedan;
	}else if(vehicle==126){//MINIVAN
		nv_transport_object = transfersPrices.minivan;
	}else if(vehicle==127){//MINIBUS
		nv_transport_object = transfersPrices.minibus;
	}else if(vehicle==220){//MINIBUS
		nv_transport_object = transfersPrices.bus;
	}
	
	if(km<50){//0-49
		transport_price_per_km = nv_transport_object.p_transfer_0_50;
	}else if(km>=50 && km<100){//50-99
		transport_price_per_km = nv_transport_object.p_transfer_50_100;
	}else if(km>=100 && km<150){//100-149
		transport_price_per_km = nv_transport_object.p_transfer_100_150;
	}else if(km>=150 && km<200){//150-199
		transport_price_per_km = nv_transport_object.p_transfer_150_200;
	}else if(km>=200 && km<250){//200-249
		transport_price_per_km = nv_transport_object.p_transfer_200_250;
	}else if(km>=250 && km<300){//250-299
		transport_price_per_km = nv_transport_object.p_transfer_250_300;
	}else if(km>=300 && km<350){//300-349
		transport_price_per_km = nv_transport_object.p_transfer_300_350;
	}else if(km>=350 && km<400){//350-399
		transport_price_per_km = nv_transport_object.p_transfer_350_400;
	}else if(km>=400){//400+
		transport_price_per_km = nv_transport_object.p_transfer_400_plus;
	}

	if(totalCrow>nv_transport_object.p_transfer_max_crowed){
		let howManyCars = Math.ceil(totalCrow / nv_transport_object.p_transfer_max_crowed);
		transport_price_per_km = parseFloat(transport_price_per_km * howManyCars);
	}
	/* New Calculation END */

	var samewaydiscount = nv_transport_object.samewaydiscount;
	var firstFromPlace = parseInt($("#mobile-startingPlace").val());
	var firstToPlace = parseInt($("#mobile-endPlace").val());
	var secondFromPlace = parseInt($("#mobile-startingPlace2").val());
	var secondToPlace = parseInt($("#mobile-endPlace2").val());
	var ex1 = $("#mobile-startdate").val().split("-");
	var ex2 = $("#double-mobile-startdate").val().split("-");

	var year = ex1[0];
	var month = (ex1[1].length<=1) ? "0"+ex1[1] : ex1[1];
	var day = (ex1[2].length<=1) ? "0"+ex1[2] : ex1[2];

	var year2 = ex2[0];
	var month2 = (ex2[1].length<=1) ? "0"+ex2[1] : ex2[1];
	var day2 = (ex2[2].length<=1) ? "0"+ex2[2] : ex2[2];

	var firstFullDate = year + "-" + month + "-" + day;
	var secondFullDate = year2 + "-" + month2 + "-" + day2;

	//same way back discount
	if(firstFromPlace==secondToPlace && firstToPlace==secondFromPlace && firstFullDate==secondFullDate){
		console.log("entered 2");
		transport_price_per_km = transport_price_per_km - ((transport_price_per_km*samewaydiscount) / 100);
	}
	/* New Calculation END */

	var ten = parseInt($("#mobile-startingPlace2 option:selected").attr("data-plus"));
	ten *= 10;
	var ten2 = parseInt($("#mobile-endPlace2 option:selected").attr("data-plus"));
	ten2*=10;

	ten = ten + ten2;

	// var cur = $("#cur").val();
	// var cur_exchange = parseFloat($("#cur_exchange").val());

	

	var totalprice = km*transport_price_per_km+ten;
	totalprice = ( isNaN(totalprice) ) ? 0 : totalprice;
	$("#totalprice2").attr("data-gelprice", (parseInt(Math.round(totalprice)) || 0));

	var usd = parseFloat($("#g-cur-exchange-usd").val());
    var eur = parseFloat($("#g-cur-exchange-eur").val());

    var totalThePrice___;
    var cur;
    if($("#g-cur__").val()=="usd"){
        totalThePrice___ = Math.round(totalprice / usd).toFixed(0); 
        cur = "$";
    }else if($("#g-cur__").val()=="eur"){
        totalThePrice___ = Math.round(totalprice / eur).toFixed(0); 
        cur = "&euro;";
    }else{
        totalThePrice___ = totalprice.toFixed(0);
        cur = "<i>A</i>";
    }

	$("#totalprice2").html((totalThePrice___ || 0)+cur);
}

$("#mobile-guests").change(function(){
	var totalCrow = parseInt($("#mobile-guests").val()) + parseInt($("#mobile-children").val()) + parseInt($("#mobile-children-under").val());
	changeTransport(totalCrow, true);
	countPriceTransportMobile();
});

$("#double-mobile-guests").change(function(){
	var totalCrow = parseInt($("#double-mobile-guests").val()) + parseInt($("#double-mobile-child").val()) + parseInt($("#double-mobile-child-under").val());
	doublechangeTransport(totalCrow, true);
	countPriceTransportMobileDouble();
});

$("#double-mobile-child-under").change(function(){
	var totalCrow = parseInt($("#double-mobile-guests").val()) + parseInt($("#double-mobile-child").val()) + parseInt($("#double-mobile-child-under").val());
	doublechangeTransport(totalCrow, true);
	countPriceTransportMobileDouble();
});


$("#mobile-children").change(function(){
	var totalCrow = parseInt($("#mobile-guests").val()) + parseInt($("#mobile-children").val()) + parseInt($("#mobile-children-under").val());
	changeTransport(totalCrow, true);
	countPriceTransportMobile();
});

$("#double-mobile-child").change(function(){
	var totalCrow = parseInt($("#double-mobile-guests").val()) + parseInt($("#double-mobile-child").val()) + parseInt($("#double-mobile-child-under").val());
	doublechangeTransport(totalCrow, true);
	countPriceTransportMobileDouble();
});


$("#double-mobile-child-under").change(function(){
	var totalCrow = parseInt($("#double-mobile-guests").val()) + parseInt($("#double-mobile-child").val()) + parseInt($("#double-mobile-child-under").val());
	doublechangeTransport(totalCrow, true);
	countPriceTransportMobileDouble();
});

$('#totalprice').bind("DOMSubtreeModified",function(){
	var totalprice = parseInt($("#totalprice").attr("data-gelprice"));
	totalprice = (isNaN(totalprice)) ? 0 : totalprice;
	var totalprice2 = parseInt($("#totalprice2").attr("data-gelprice"));
	totalprice2 = (isNaN(totalprice2)) ? 0 : totalprice2;
	
	var usd = parseFloat($("#g-cur-exchange-usd").val());
    var eur = parseFloat($("#g-cur-exchange-eur").val());

    var totalThePrice___;
    var totalThePrice___2;
    var cur;
    if($("#g-cur__").val()=="usd"){
        totalThePrice___ = (totalprice / usd).toFixed(0); 
        totalThePrice___2 = (totalprice2 / usd).toFixed(0); 
        cur = "$";
    }else if($("#g-cur__").val()=="eur"){
        totalThePrice___ = (totalprice / eur).toFixed(0); 
        totalThePrice___2 = (totalprice2 / eur).toFixed(0); 
        cur = "&euro;";
    }else{
        totalThePrice___ = totalprice.toFixed(0);
        totalThePrice___2 = totalprice2.toFixed(0);
        cur = "<i>A</i>";
    }
    
    $("#totalpricefinal").html(( parseInt(totalThePrice___)+parseInt(totalThePrice___2) || 0)+cur);
});

$('#totalprice2').bind("DOMSubtreeModified",function(){
	var totalprice = parseInt($("#totalprice").attr("data-gelprice"));
	totalprice = (isNaN(totalprice)) ? 0 : totalprice;
	var totalprice2 = parseInt($("#totalprice2").attr("data-gelprice"));
	totalprice2 = (isNaN(totalprice2)) ? 0 : totalprice2;
	// var cur = $("#cur").val();


	var usd = parseFloat($("#g-cur-exchange-usd").val());
    var eur = parseFloat($("#g-cur-exchange-eur").val());

    var totalThePrice___;
    var totalThePrice___2;
    var cur;
    if($("#g-cur__").val()=="usd"){
        totalThePrice___ = (totalprice / usd).toFixed(0); 
        totalThePrice___2 = (totalprice2 / usd).toFixed(0); 
        cur = "$";
    }else if($("#g-cur__").val()=="eur"){
        totalThePrice___ = (totalprice / eur).toFixed(0); 
        totalThePrice___2 = (totalprice2 / eur).toFixed(0); 
        cur = "&euro;";
    }else{
        totalThePrice___ = totalprice.toFixed(0);
        totalThePrice___2 = totalprice2.toFixed(0);
        cur = "<i>A</i>";
    }
	$("#totalpricefinal").html(( parseInt(totalThePrice___)+parseInt(totalThePrice___2) || 0)+cur);
});


$(document).ready(function(){
	//$(".LocationDropDown2 .Item:eq(0) input").click();
	//$(".LocationDropDown3 .Item:eq(1) input").click();
});