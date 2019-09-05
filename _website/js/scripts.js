window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    // Handle page restore.
    window.location.reload();
  }
});

function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}

function ColorDistance(){
    $('.CheckBoxItem label').css('color','#333333');
    $('.CheckBoxItem .TripCheckbox:checked').each(function(i, e){
        var datamap = $(e).attr("data-map").split(":");
        var latmap = datamap[0].replace(" ", "");
        var longmap = datamap[1].replace(" ", "");
        latLngA = new google.maps.LatLng(latmap,longmap);

        $('.CheckBoxItem .TripCheckbox').each(function(index, element) {
            var datamap2 = $(element).attr("data-map").split(":");
            var latmap2 = datamap2[0].replace(" ", "");
            var longmap2 = datamap2[1].replace(" ", "");
            latLngB = new google.maps.LatLng(latmap2,longmap2);
            if(typeof google.maps.geometry !== "undefined"){
                distance = google.maps.geometry.spherical.computeDistanceBetween(latLngA, latLngB);
                if(distance <= 11000){
                    $(this).next('label').css('color','green');
                }
            }
        });
    });
}

function changeUrl(){
    var val = $("#slider").slider("value");
    var input_lang = $("#input_lang").val();
    $("#current_page").val(1);
    var current_page = (typeof $("#current_page").val()=="undefined" || $("#current_page").val()<=0) ? 1 : $("#current_page").val();
    var cats = new Array();
    var regs = new Array();
    var itemsList = "";
    var x = 1;
    $(".CategoriesDropDown .Item").each(function(){
        if($(".TripCheckbox:checked", this).length){
            cats.push($(".TripCheckbox", this).attr("data-id"));
            itemsList += "<div class=\"Item\" id=\"i"+x+"\">"+escapeHtml($(".TripCheckbox", this).val())+" <div class=\"Remove removeItemButton\" data-type=\"catalog\" data-itemid=\"i"+x+"\" data-value=\""+escapeHtml($(".TripCheckbox", this).val())+"\" data-checkboxid=\""+$(".TripCheckbox", this).attr("id")+"\"><i class=\"fa fa-times\"></i></div></div>";
        }
        x++;
    });

    //RegiosSearchDropDown
    $(".RegiosSearchDropDown .Item").each(function(){
        if($(".TripCheckbox:checked", this).length){
            regs.push($(".TripCheckbox", this).attr("data-id"));
            itemsList += "<div class=\"Item\" id=\"i"+x+"\">"+$(".TripCheckbox", this).val()+" <div class=\"Remove removeItemButton\" data-type=\"regions\" data-itemid=\"i"+x+"\" data-value=\""+escapeHtml($(".TripCheckbox", this).val())+"\" data-checkboxid=\""+$(".TripCheckbox", this).attr("id")+"\"><i class=\"fa fa-times\"></i></div></div>";
        }
        x++;
    });
    if(val>0){
        itemsList += "<div class=\"Item\" id=\"i"+x+"\">"+val+" <div class=\"Remove removeItemButton\" data-type=\"price\" data-itemid=\"i"+x+"\" data-value=\""+val+"\" data-checkboxid=\"0\"><i class=\"fa fa-times\"></i></div></div>";
    }

    $(".itemsListBox").html(itemsList);
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"loadcatalog", 
            input_lang:input_lang, 
            current_page:current_page,                  
            cat:cats.join(),                  
            reg:regs.join(),
            pri:val,
            token:CSRF_token           
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        var errorFields = obj.Error.errorFields;
        if(obj.Error.Code==1){            
        }else{
            $(".ToursList .tourCatalogList").html(obj.Success.Html);
        }
        $(".SearchResultText #g-main-serach-result").text(obj.Error.out_couned);
    });

    window.history.pushState({}, "", "/"+input_lang+"/ongoing-tours/?page="+current_page+"&pri="+val+"&cat="+cats.join()+"&reg="+regs.join());
}

function changeUrlMobile(){
    var val = $("#slider").slider("value");
    var input_lang = $("#input_lang").val();
    $("#current_page").val(1);
    var current_page = (typeof $("#current_page").val()=="undefined" || $("#current_page").val()<=0) ? 1 : $("#current_page").val();
    
    var cats = $("#mobile-categories").val();
    cats = (cats!="") ? cats.split(",") : [];
    var regs = $("#mobile-regions").val();
    regs = (regs!="") ? regs.split(",") : []; 

    var CSRF_token = $('meta[name=CSRF_token]').attr("value");

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"loadcatalog", 
            input_lang:input_lang, 
            current_page:current_page,                  
            cat:cats.join(),                  
            reg:regs.join(),
            pri:val,
            token:CSRF_token           
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        var errorFields = obj.Error.errorFields;
        if(obj.Error.Code==1){            
        }else{
            $(".ToursList .row").html(obj.Success.Html);
        }
        $(".SearchResultText span").text(obj.Error.out_couned);
    });

    window.history.pushState({}, "", "/"+input_lang+"/ongoing-tours/?page="+current_page+"&pri="+val+"&cat="+cats.join()+"&reg="+regs.join());
}

function countAdditionalServices(){
    var guests = parseInt($(".input-number").val());
    var children = parseInt($(".planner-children").val());
    var form = $("#plantripform");
    var input = "";
    var html_out = "";
    var gCur = "<i>A</i>";
    var gCurExchange = 1;
    var usd = parseFloat($("#g-cur-exchange-usd").val());
    var eur = parseFloat($("#g-cur-exchange-eur").val());
    if($("#g-cur__").val()=="usd"){
        gCurExchange = usd; 
        gCur = "$";
    }else if($("#g-cur__").val()=="eur"){
        gCurExchange = eur; 
        gCur = "&euro;";
    }

    $("#plantripform input[name='hotels[]']").remove();
    $("#plantripform input[name='cuisune[]']").remove();
    $("#plantripform input[name='guide[]']").remove();
    $("#plantripform input[name='transport[]']").remove();
    var fx = 1;
    $(".planner-hotels").each(function(){
        let id = $(this).attr("id");
        let val = $(this).val();
        let daily = $("#daily").val();
        let price = parseInt($(this).attr("data-price")) * guests;
        price += parseInt(parseInt($(this).attr("data-price")) / 2) * children;
        let hotelid = parseInt($(this).attr("data-hotelid"));

        if(document.getElementById(id).checked){
            input += "<input type=\"hidden\" name=\"hotels[]\" class=\"remitem-hotels"+fx+"\" data-title=\""+g_htmlentities(val)+"\" data-price=\""+price+"\" value=\""+hotelid+"\" />";
            
            html_out += "<div class=\"Item Item_2 remitem-hotels"+fx+"\">";
            html_out += "<div class=\"Icon HotelIcon\"></div>";
            html_out += "<li>";
            html_out += "<label>"+g_htmlentities(val)+" <br>"+daily+"</label>";
            html_out += "<span data-gelprice=\""+(parseInt(price) || 0)+"\">"+(parseInt(price / gCurExchange) || 0)+gCur+"</span>";
            html_out += "<em onclick=\"$('.remitem-hotels"+fx+"').remove(); $('.planner-hotels').prop('checked', false); $('.Hotels_Main_Checkbox').prop('checked', false); $('.hostelValue').html(''); \">x</em>";
            html_out += "</li>";
            html_out += "</div>";
        }
        fx++;
    });

    var fx2 = 1;
    $(".planner-cuisune").each(function(){
        let id = $(this).attr("id");
        let daily = $("#daily").val();

        if(document.getElementById(id).checked){
            console.log(id);
            let val = $(this).val();
            let cuisuneid = parseInt($(this).attr("data-cuisuneid"));
            let people = parseInt($(".guestsN[data-id='"+cuisuneid+"']").val());
            if(people<=0){
                people = parseInt($(".guestsN-mobile[data-id='"+cuisuneid+"']").val());
            }
            let price = parseInt($(this).attr("data-price")) * people;
            
            
            input += "<input type=\"hidden\" name=\"cuisune[]\" class=\"remitem-cuisune"+fx2+"\" data-title=\""+g_htmlentities(val)+"\" data-people=\""+people+"\" data-price=\""+(parseInt(price / gCurExchange) || 0)+"\" value=\""+cuisuneid+"\" />";
            
            html_out += "<div class=\"Item Item_2 remitem-cuisune"+fx2+"\">";
            html_out += "<div class=\"Icon Cuisune\"></div>";
            html_out += "<li>";
            html_out += "<label>"+g_htmlentities(val)+" <br>"+daily+"</label>";
            
            html_out += "<span data-gelprice=\""+(parseInt(price) || 0)+"\">"+(parseInt(price / gCurExchange) || 0)+gCur+"</span>";
            html_out += "<em onclick=\"$('.remitem-cuisune"+fx2+"').remove(); $('#"+id+"').prop('checked', false).trigger('change');\">x</em>";
            html_out += "</li>";
            html_out += "</div>";
        }
        fx2++;
    });

    var fx3 = 1;
    $(".planner-guide").each(function(){
        let id = $(this).attr("id");
        let val = $(this).val();
        let price = parseInt($(this).attr("data-price"));
        let guideid = parseInt($(this).attr("data-guideid"));
        let daily = $("#daily").val();

        if(document.getElementById(id).checked){
            input += "<input type=\"hidden\" name=\"guide[]\" class=\"remitem-guide"+fx3+"\" data-title=\""+g_htmlentities(val)+"\" data-price=\""+(parseInt(price / gCurExchange) || 0)+"\" value=\""+guideid+"\" />";
            
            html_out += "<div class=\"Item Item_2 remitem-guide"+fx3+"\">";
            html_out += "<div class=\"Icon GuideIcon\"></div>";
            html_out += "<li>";
            html_out += "<label>"+g_htmlentities(val)+" <br>"+daily+"</label>";
            html_out += "<span data-gelprice=\""+(parseInt(price) || 0)+"\">"+(parseInt(price / gCurExchange) || 0)+gCur+"</span>";
            html_out += "<em onclick=\"$('.remitem-guide"+fx3+"').remove(); $('.planner-guide').prop('checked', false); $('.LangValue').html(''); $('#Guide').prop('checked', false); \">x</em>";
            html_out += "</li>";
            html_out += "</div>";
        }
        fx3++;
    });

    form.append(input);
    $(".addd").html(html_out);
}


$(document).on("change", "#insurance123", function(){
    var checked = $(this).prop("checked");
    // if(checked){
    //     $('#InsuarancePopupBox').modal('show');
    // }
});

$(document).on("click", ".addCart", function(e){
    var inside = ($(this).attr("data-inside") === "true");
    var redirectToCart = ($(this).attr("data-redirect") === "true");
    var input_lang = $("#input_lang").val();
    var id = $(this).attr("data-id");
    var title = $(this).attr("data-title");
    var errorText = $(this).attr("data-errortext");

    var guestNuber = 1;
    var children = parseInt($(".tour-child-number").val());
    var childrenunder = parseInt($(".tour-child-number-under").val());
    if($('.tour-guest-number').length){
        guestNuber = parseInt($('.tour-guest-number').val());
    }

    var insurance123 = ($("#insurance123").prop("checked")==true) ? 1 : 2;
    var g_insuarance_damzgvevi = $(".g-insuarance-damzgvevi").val();
    var g_insuarance_dazgveuli = $(".g-insuarance-dazgveuli").val();
    var g_insuarance_misamarti = $(".g-insuarance-misamarti").val();
    var g_insuarance_dabtarigi = $(".g-insuarance-dabtarigi").val();
    var g_insuarance_pasporti = $(".g-insuarance-pasporti").val();
    var g_insuarance_piradinomeri = $(".g-insuarance-piradinomeri").val();
    var g_insuarance_telefonis = $(".g-insuarance-telefonis").val();
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");

    if($(this).hasClass("active")){
        $(this).removeClass("active");
    }else{
        $(this).addClass("active");
    }

    if(inside){
        inside = $(".DatePicker2").val();
    }

    var tra = "sedan";
    if($("#tra126").prop("checked")){
        tra = "minivan";
    }else if($("#tra127").prop("checked")){
        tra = "bus";
    }

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"updateCart", 
            input_lang:input_lang, 
            guestNuber:guestNuber, 
            children:children,
            childrenunder:childrenunder,
            id:id,
            insurance123:insurance123, 
            g_insuarance_damzgvevi:g_insuarance_damzgvevi,
            g_insuarance_dazgveuli:g_insuarance_dazgveuli, 
            g_insuarance_misamarti:g_insuarance_misamarti,
            g_insuarance_dabtarigi:g_insuarance_dabtarigi,
            g_insuarance_pasporti:g_insuarance_pasporti,
            g_insuarance_piradinomeri:g_insuarance_piradinomeri,
            g_insuarance_telefonis:g_insuarance_telefonis,
            inside:inside, 
            tra:tra,
            token:CSRF_token         
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){   
            $('#ErrorModal .modal-dialog .modal-body .Title').text(title);
            $('#ErrorModal .modal-dialog .modal-body .Text').text(obj.Error.Text);
            $('#ErrorModal').modal('show');
        }else{
            if(!redirectToCart){
                if($(".addCart[data-redirect='true']").hasClass("g-visiable-button")){
                    $(".addCart[data-redirect='true']").removeClass("g-visiable-button");
                    $(".addCart[data-redirect='true']").fadeOut();
                }else{
                    $(".addCart[data-redirect='true']").addClass("g-visiable-button");
                    $(".addCart[data-redirect='true']").fadeIn();
                }

                $('#SuccessModal .modal-dialog .modal-body .Title').text(title);
                $('#SuccessModal .modal-dialog .modal-body .Text').text(obj.Success.Text);
                $('#SuccessModal').modal('show');
            }else{
                location.href = "/"+input_lang+"/cart";
            }
        }
        $(".HeaderCardIcon span").text(obj.Success.countCartitem);
    });

});


$(document).on("click", ".changeCurrency",function(){
    var input_lang = $("#input_lang").val();
    var cur = $(this).attr("data-cur");
    $(".currencyBox span").html("...");
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"changeCurrency", 
            input_lang:input_lang, 
            cur:cur          
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){   
        }else{
            $(".g-aj-currency").text(obj.Success.Currency);
            $("#g-cur__").val(obj.Success.Currency);
            $(".changeCurrency").show();
            $(".cur-aj-"+cur).hide();
            var usd = parseFloat($("#g-cur-exchange-usd").val());
            var eur = parseFloat($("#g-cur-exchange-eur").val());
            
            $("[data-gelprice]").each(function(e){
                var getPrice = parseFloat(this.getAttribute("data-gelprice"));

                if(
                    typeof this.getAttribute("id") !== "undefined" && 
                    (   
                        this.getAttribute("id") == "ticketPrice__" || 
                        this.getAttribute("id") == "cuisunePrice__" || 
                        this.getAttribute("id") == "hotelPrice__" 

                    )
                ){
                    return true;
                }
                
                var totalThePrice___;
                var cur;
                if($("#g-cur__").val()=="usd"){
                    totalThePrice___ = (getPrice / usd).toFixed(0); 
                    cur = "$";
                }else if($("#g-cur__").val()=="eur"){
                    totalThePrice___ = (getPrice / eur).toFixed(0); 
                    cur = "&euro;";
                }else{
                    totalThePrice___ = getPrice.toFixed(0);
                    cur = "<i>A</i>";
                }

                this.innerHTML = totalThePrice___ + cur;
            });
        }
    });
});

$(document).on("click", ".loadmoreSights",function(){
    var input_lang = $("#input_lang").val();
    var loadedLimit = $(".SightsList").attr("data-loadedLimit");
    var elem = $(this);
    elem.append("<span>...</span>");
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"loadmoreSights", 
            input_lang:input_lang, 
            loadedLimit:loadedLimit          
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){   
        }else{
           $("span", elem).remove();
           $(".SightsList").attr("data-loadedLimit", obj.Success.NewLimit);
           $(".SightsList .row").append(obj.Success.Html);
        }
    });
});

$(document).on("change", ".currency-mobile", function(){
    var input_lang = $("#input_lang").val();
    var cur = $(this).val();

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"changeCurrency", 
            input_lang:input_lang, 
            cur:cur          
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){   
        }else{
            location.reload();
        }
    });
});

$(document).on("click", ".addTransportToCart", function(e){
    var redirectToCart = ($(this).attr("data-redirect") === 'true');
    var input_lang = $("#input_lang").val();

    var km = 0;
    var km2 = 0;
    var startplace = "";
    var endplace = "";
    var startdatetrans = "";
    var timeTrans = ""; 
    var guestnumber = "";
    var children = "";
    var underchildren = "";

    var startplace2 = "";
    var endplace2 = "";
    var startdatetrans2 = "";
    var timeTrans2 = ""; 
    var guestnumber2 = "";
    var children2 = "";
    var underchildren2 = "";

    var TransporDropDownId = "";
    var TransporDropDownId2 = "";

    var insurance123 = ($("#insurance123").prop("checked")==true) ? 1 : 2; 
    var g_insuarance_damzgvevi = $(".g-insuarance-damzgvevi").val();
    var g_insuarance_dazgveuli = $(".g-insuarance-dazgveuli").val();
    var g_insuarance_misamarti = $(".g-insuarance-misamarti").val();
    var g_insuarance_dabtarigi = $(".g-insuarance-dabtarigi").val();
    var g_insuarance_pasporti = $(".g-insuarance-pasporti").val();
    var g_insuarance_piradinomeri = $(".g-insuarance-piradinomeri").val();
    var g_insuarance_telefonis = $(".g-insuarance-telefonis").val();
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");

    /* desctop start */
    km = $("#km").val();
    km2 = $("#double-km").val()
    startplace = $(".LocationDropDown2 .Item input[type='checkbox']:checked").attr("data-id");
    endplace = $(".LocationDropDown3 .Item input[type='checkbox']:checked").attr("data-id");        
    startdatetrans = $(".startdatetrans").val();        
    timeTrans = $(".timeTrans").val();        
    guestnumber = $("#guest-number").val();        
    children = $("#children-number").val();        
    underchildren = $("#children-under").val();        
    TransporDropDownId = $(".TransporDropDown .Item input[type='checkbox']:checked").attr("data-id"); 
    
    if($("#doubleway").is(":visible")){
        startplace2 = $(".LocationDropDown4 .Item input[type='checkbox']:checked").attr("data-id");
        endplace2 = $(".LocationDropDown5 .Item input[type='checkbox']:checked").attr("data-id");
        timeTrans2 = $(".double-timeTrans").val();
        startdatetrans2 = $(".double-startdatetrans").val();
        guestnumber2 = $("#double-guest-number").val();
        children2 = $("#double-children-number").val();
        underchildren2 = $("#double-children-under-number").val();
        TransporDropDownId2 = $(".double-TransporDropDown .Item input[type='checkbox']:checked").attr("data-id"); 
    }
    /* desctop end */

    /* mobile start */
    if(
        $("#mobile-startingPlace").val()!=null && 
        $("#mobile-endPlace").val()!=null 
    ){
        km = $("#km").val();
        km2 = $("#double-km").val();
        startplace = $("#mobile-startingPlace").val();
        endplace = $("#mobile-endPlace").val();        
        startdatetrans = $("#mobile-startdate").val();        
        timeTrans = $("#mobile-time").val();        
        guestnumber = $("#mobile-guests").val();        
        children = $("#mobile-children").val();        
        underchildren = $("#mobile-children-under").val();        
        TransporDropDownId = $("#mobile-transpor").val();        
        if($("#mobile-doublewaybox").is(":visible")){
            startplace2 = $("#mobile-startingPlace2").val();
            endplace2 = $("#mobile-endPlace2").val();
            startdatetrans2 = $("#double-mobile-startdate").val();
            timeTrans2 = $("#double-mobile-time").val();
            guestnumber2 = $("#double-mobile-guests").val();
            children2 = $("#double-mobile-child").val();
            underchildren2 = $("#double-mobile-child-under").val();
            TransporDropDownId2 = $("#double-mobile-transpor").val();
        }
    }
    /* mobile end */
    

    var title = $(this).attr("data-title");
    var successText = $(this).attr("data-successText");

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"insertTransCart", 
            input_lang:input_lang, 
            km:km,          
            km2:km2,          
            startplace:startplace,          
            endplace:endplace, 
            startdatetrans:startdatetrans,           
            timeTrans:timeTrans,            
            guestnumber:guestnumber,
            children:children,
            underchildren:underchildren,
            TransporDropDownId:TransporDropDownId,  
            startplace2:startplace2,          
            endplace2:endplace2, 
            startdatetrans2:startdatetrans2,           
            timeTrans2:timeTrans2,            
            guestnumber2:guestnumber2,
            children2:children2,
            underchildren2:underchildren2,
            TransporDropDownId2:TransporDropDownId2,
            insurance123:insurance123, 
            g_insuarance_damzgvevi:g_insuarance_damzgvevi,
            g_insuarance_dazgveuli:g_insuarance_dazgveuli, 
            g_insuarance_misamarti:g_insuarance_misamarti,
            g_insuarance_dabtarigi:g_insuarance_dabtarigi,
            g_insuarance_pasporti:g_insuarance_pasporti,
            g_insuarance_piradinomeri:g_insuarance_piradinomeri,
            g_insuarance_telefonis:g_insuarance_telefonis,
            token:CSRF_token   
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){            
            $('#ErrorModal .modal-dialog .modal-body .Title').text(title);
            $('#ErrorModal .modal-dialog .modal-body .Text').text(obj.Error.Text);
            $('#ErrorModal').modal('show');
        }else{
            if(!redirectToCart){
                var cartCount = parseInt($(".HeaderCardIcon span").text()) + 1;
                $(".HeaderCardIcon span").text(cartCount);
                $('#SuccessModal .modal-dialog .modal-body .Title').text(title);
                $('#SuccessModal .modal-dialog .modal-body .Text').text(obj.Success.Text);
                $('#SuccessModal').modal('show');
            }else{
                location.href = "/"+input_lang+"/cart";
            }
        }
    });
});

$(document).on("click", ".addPlanTripToCart", function(){
    var redirectToCart = ($(this).attr("data-redirect") === 'true');
    var input_lang = $("#input_lang").val();
    var places = new Array();
    var title = $(this).attr("data-title");
    var startPlace = 856; // tbilisi
    if(typeof $(".LocationDropDown2 .TripCheckbox:checked").attr("data-id") !== "undefined"){
        startPlace = parseInt($(".LocationDropDown2 .TripCheckbox:checked").attr("data-id"));
    }
    if(typeof $(".LocationDropDown1 .TripCheckbox:checked").attr("data-id") !== "undefined"){
        startPlace = parseInt($(".LocationDropDown1 .TripCheckbox:checked").attr("data-id"));
    }
    var startDatePicker = $(".startDatePicker").val();
    var endDatePicker = $(".endDatePicker").val();
    var guests = parseInt($(".input-number").val());
    var children = parseInt($(".planner-children").val());
    var childrenunder = parseInt($(".planner-childrenunder").val());
    var errorText = $(this).attr("data-errorText");
    var successText = $(this).attr("data-successText");
    $("#plantripform input[name='plantrip_direction[]']").each(function(e){
        places.push($(this).val());
    });

    var insurance123 = ($("#insurance123").prop("checked")==true) ? 1 : 2;
    var g_insuarance_damzgvevi = $(".g-insuarance-damzgvevi").val();
    var g_insuarance_dazgveuli = $(".g-insuarance-dazgveuli").val();
    var g_insuarance_misamarti = $(".g-insuarance-misamarti").val();
    var g_insuarance_dabtarigi = $(".g-insuarance-dabtarigi").val();
    var g_insuarance_pasporti = $(".g-insuarance-pasporti").val();
    var g_insuarance_piradinomeri = $(".g-insuarance-piradinomeri").val();
    var g_insuarance_telefonis = $(".g-insuarance-telefonis").val();
    var tkn = $("#totalkm").val();
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");


    var hotel = (typeof $("#plantripform input[name='hotels[]']").val() !== "undefined") ? parseInt($("#plantripform input[name='hotels[]']").val()) : 0;
    
    var cuisune = [];
    //data-people
    $("#plantripform input[name='cuisune[]']").each(function(){
        if(
            typeof $(this).attr("data-people") !== "undefined" && 
            typeof $(this).val() !== "undefined" 
        ){
            let people = parseInt($(this).attr("data-people"));
            let cuisuneId = parseInt($(this).val());

            cuisune.push({
                people: people,
                cuisuneId:cuisuneId
            });
        }
    });

    cuisune = JSON.stringify(cuisune);

    var guide = (typeof $("#plantripform input[name='guide[]']").val() !== "undefined") ? parseInt($("#plantripform input[name='guide[]']").val()) : 0;
    var transport = (typeof $(".planner-transport:checked").attr("data-id") !== "undefined") ? parseInt($(".planner-transport:checked").attr("data-id")) : 0;

    var plannedDay = parseInt($("#plannedDay").val());
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"addTripPlanToCart", 
            input_lang:input_lang, 
            startPlace:startPlace, 
            startDatePicker:startDatePicker, 
            endDatePicker:endDatePicker, 
            guests:guests, 
            children:children, 
            childrenunder:childrenunder, 
            places:places.join(),
            hotel:hotel,
            guide:guide,
            transport:transport, 
            cuisune:cuisune,
            tkn:tkn,
            dd:plannedDay,
            insurance123:insurance123,
            g_insuarance_damzgvevi:g_insuarance_damzgvevi,
            g_insuarance_dazgveuli:g_insuarance_dazgveuli, 
            g_insuarance_misamarti:g_insuarance_misamarti,
            g_insuarance_dabtarigi:g_insuarance_dabtarigi,
            g_insuarance_pasporti:g_insuarance_pasporti,
            g_insuarance_piradinomeri:g_insuarance_piradinomeri,
            g_insuarance_telefonis:g_insuarance_telefonis,
            token:CSRF_token       
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        
        if(obj.Error.Code==1){  
            $('#ErrorModal .modal-dialog .modal-body .Title').text(title);
            $('#ErrorModal .modal-dialog .modal-body .Text').text(obj.Error.Text);
            $('#ErrorModal').modal('show');
        }else{
            if(!redirectToCart){
                $('#SuccessModal .modal-dialog .modal-body .Title').text(title);
                $('#SuccessModal .modal-dialog .modal-body .Text').text(successText);
                $('#SuccessModal').modal('show');
                /* clear */
                $(".CheckBoxItem").each(function(){
                    if($("input[type='checkbox']:checked", this).length){
                        $("input[type='checkbox']:checked", this).click();
                    }
                });

                setTimeout(function(){
                    location.reload();
                }, 1500);
            }else{
                location.href = "/"+input_lang+"/cart";
            }
        }
        
        $(".HeaderCardIcon span").text(obj.Success.countCartitem);
    });
});

$(document).on("click", ".deleteCartItem", function(){
    var input_lang = $("#input_lang").val();
    var id = $(this).attr("data-id");
    var pr = parseFloat($("#r"+id).attr("data-price"));
    var sumcount = parseFloat($(".SumCount span").text());
    var newTotal = parseFloat(sumcount-pr).toFixed(2);
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"removeCartItem", 
            input_lang:input_lang, 
            id:id,
            token:CSRF_token          
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){            
        }else{            
            if($(".SumCount span").length){
                $(".SumCount span").html(newTotal + " <i>A</i>");
            }
            $("#r"+id).remove();

            location.reload();
        }
        $(".HeaderCardIcon span").text(obj.Success.countCartitem);
    });
});

$(document).on("change", ".mselector", function(){
    var values = new Array();
    var attached = $(this).attr("data-attached");
    $(".mselector").each(function(){
        if($(this).prop("checked")){
            values.push($(this).val());
        }
    });

    var defaultText = $(this).parent().parent().prev().attr("data-defaulttext"); 
    if(values.length<=0){
        $(this).parent().parent().prev().html(defaultText);
    }else{
        var selectText = new Array();
        for(var i = 0; i <= (values.length-1); i++){
            selectText.push($(".mselector[value='"+values[i]+"']").attr("data-val"));
        }
        
        $(this).parent().parent().prev().html(selectText.join(", "));
    }

    $(attached).val(values.join());
    $(attached).change(); 
});

$(document).on("change", ".mselector2", function(){
    var values = new Array();
    var attached = $(this).attr("data-attached");
    $(".mselector2").each(function(){
        if($(this).prop("checked")){
            values.push($(this).val());
        }
    });

    var defaultText = $(this).parent().parent().prev().attr("data-defaulttext"); 
    if(values.length<=0){
        $(this).parent().parent().prev().html(defaultText);
    }else{
        // var selectText = " Selected";
        // selectText = ($("#input_lang").val()=="ge") ? " შერჩეული" : selectText;
        // selectText = ($("#input_lang").val()=="ru") ? " выбран" : selectText;
        //console.log($(".mselector[value='90']").attr("data-val"));
        //$(this).parent().parent().prev().html(values.length + selectText);
        var selectText = new Array();
        for(var i = 0; i <= (values.length-1); i++){
            selectText.push($(".mselector2[value='"+values[i]+"']").attr("data-val"));
        }
        
        $(this).parent().parent().prev().html(selectText.join(", "));
    }

    $(attached).val(values.join());
    $(attached).change(); 
});

$(document).on("click", ".g-selector-mainbox .g-selector-title", function(){
    //$(".g-selector-mainbox .g-mselector-box").slideToggle();
    $(this).next().slideToggle();
});

// 
$(document).on("click", ".askAgaindelete", function(){
    $(".askAgaindelete").append("<span> ?</span>");
    $(".askAgaindelete").addClass("deleteCartItem").removeClass("askAgaindelete").css({"background-color":"#27774d", "color":"white"});
    $(".DeleteButton span").show();
    $(".DeleteButton").css({"border":"solid #27774d 1px !important", "padding":"8px 20px", "border-radius":"25px"});
});


$(document).on("click", ".removeItemButton", function(e){
    var datatype = $(this).attr("data-type");
    var dataitemid = $(this).attr("data-itemid");
    var datavalue = $(this).attr("data-value");
    var checkboxid = $(this).attr("data-checkboxid");

    $("#"+checkboxid).prop('checked', false);
    $("#"+dataitemid).remove();
    
    if(datatype=="catalog"){
        $('text:contains('+datavalue+')', '.CatagoryName').remove();
    }

    if(datatype=="regions"){
        $('text:contains('+datavalue+')', '.RegiosName').remove();
    }

    if(datatype=="price"){
        $("#slider").slider("value", 0);
        $("#slider label").text(0);
        $("#AmountLabelID label").text(0);
    }

    changeUrl();
});

$(document).ready(function() {

    $('.PartnersList').slick({
        dots: false,
        infinite: false,
        speed: 800,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              }
            }
          ]
    });


    $('.BigImageSlide').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.SmallImageSlide'
    });
    $('.SmallImageSlide').slick({
        slidesToShow: 14,
        slidesToScroll: 1,
        asNavFor: '.BigImageSlide',
        //dots: true,
        //centerMode: true,
        focusOnSelect: true,
        responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              }
            }
          ]
    });

    

    //$('#PromptModal').modal('show')
    //$('#SearchModal').modal('show')


    $('.CategoriesDropDown input').change(function() {
      if (this.checked) {
        $li = $(' <text> </text> ');
        $li.text(this.value);
        $('.CatagoryName').append($li);
      }
      else {
        $('text:contains('+this.value+')', '.CatagoryName').remove();
      }
      changeUrl();
    });


    $('.DestinationDropDown input').change(function() {
      if (this.checked) {
        $li = $(' <text> </text> ');
        $li.text(this.value);
        $('.DestValue').append($li);
      }
      else {
        $('text:contains('+this.value+')', '.DestValue').remove();
      }
    });


    $('.RegiosSearchDropDown input').change(function() {
      if (this.checked) {
        $li = $(' <text> </text> ');
        $li.text(this.value);
        $('.RegiosName').append($li);
      }
      else {
        $('text:contains('+this.value+')', '.RegiosName').remove();
      }
      changeUrl();
    });


    $('.DatePicker').datepicker({
        format: 'yyyy-mm-dd',
        ignoreReadonly: true,
        autoclose:true
    });

    $('.BookNowButton').click(function(e){
        e.stopPropagation();
        e.preventDefault();
        $('.BookNowRightDiv').toggleClass('ShowBookWindow');
        $('body').toggleClass('BookNowBackground');
    });

    $('.PaymentMethod .Item').click(function(e){ 
        $('.PaymentMethod .Item').removeClass('active'); 
        $(this).toggleClass('active'); 
    });
 

 



$(document).on('click', '.SearchFilterItem .dropdown-menu', function(e) {
    e.stopPropagation();
});

$('.double-btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }

});



 
$('.btn-number').click(function(e){
    e.preventDefault();
    if($(this).attr("data-field")!="quantn[400]" && $(this).attr("data-field")!="nquant[400]" && $(this).attr("data-field")!="quant[900]"){ // if not under 0-5 children
        $(this).attr("disabled", "disabled");     
    }
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());

    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
        }
    } else {
        input.val(0);
    }

});


if (document.documentElement.clientWidth > 992) { 
    $(".DivScroll").slimScroll({
        size: '8px', 
        width: '100%', 
        height: '100%', 
        color: '#c7a95c', 
        allowPageScroll: true, 
        alwaysVisible: true,
        railVisible: true, 
    });
}





    
   


var $star_rating = $('.RatingStars .fa');

var SetRatingStar = function() {
    return $star_rating.each(function() {
        if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
            return $(this).addClass('active');
        } else {
            return $(this).removeClass('active');
        }
    });
};

$star_rating.on('click', function() {
    $star_rating.siblings('input.rating-value').val($(this).data('rating'));
    return SetRatingStar();
});

SetRatingStar();
 


});

$(document).ready(function() {
    
    $('#MyProfileMenuSelect select').on('change', function (e) {
        $('#ProfileSidebar li .tabLink').eq($(this).val()).tab('show'); 
        if(parseInt($(this).val())==4){
            var lang = $("#input_lang").val();
            location.href = "/"+lang+"/registration";
        }
    });
    
    $('#MyProfileMenuSelect select').on('change', function (e) {
        $('#SingleTabMenu li a').eq($(this).val()).tab('show'); 
    });

});


function openCloseMenuMobile(){
    if($(".MenuHamburger").hasClass("OpenMenu")){
        $(".MenuHamburger").removeClass("OpenMenu");
        $(".MobileMenuDiv").css("left","-100%");
        $("body").removeAttr("style");
    }else{
        $(".MenuHamburger").addClass("OpenMenu");
        $(".MobileMenuDiv").css("left","0");
        $("body").css("overflow-y","hidden");
    }
}


/********************* RESPONSIVE JS **********************/
$(document).ready(function() {


        if (document.documentElement.clientWidth < 992) { 
            $('.ToursList .row').slick({
                dots: false,
                infinite: false,
                arrows: true,
                speed: 800,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000
            })
            $('.BlogList .row').slick({
                dots: false,
                infinite: false,
                arrows: true,
                speed: 800,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000
            })
        }
      

        
         
    $(".CheckBoxItem").hover(function(evt){
        var th = $(this);
       
        if(evt.type == 'mouseenter'){

            var imgurl = $("label .LoadImage", th).attr("data-image");
            var loaded = $("label .LoadImage", th).attr("data-loaded");
            if(typeof imgurl !== "undefined" && loaded!="true"){
                var out = "<div style=\"background-image: url('"+imgurl+"'); width:100%; height:180px; background-size: cover;\"></div>";
                $("label .LoadImage", th).html(out);
                $("label .LoadImage", th).attr("data-loaded","true");
            }

            var div = $(".ShowWindow1",th).clone();
            div.css({
                position: 'absolute',
                top: th.offset().top - 10,
                left: th.offset().left + 180,
                display: 'block'

            }).addClass("ShowWindow");
            $("body").prepend(div);
        }else if(evt.type == 'mouseleave'){
            $(".ShowWindow").remove();
        }
    })
         
 
         
        


});


$(document).on("click", ".g-insurance-save-button", function(){
    if(
        typeof $(".g-insuarance-damzgvevi").val() == "undefined" ||
        $(".g-insuarance-damzgvevi").val() == "" || 
        typeof $(".g-insuarance-dazgveuli").val() == "undefined" ||
        $(".g-insuarance-dazgveuli").val() == "" || 
        typeof $(".g-insuarance-misamarti").val() == "undefined" ||
        $(".g-insuarance-misamarti").val() == "" || 
        typeof $(".g-insuarance-dabtarigi").val() == "undefined" ||
        $(".g-insuarance-dabtarigi").val() == "" || 
        typeof $(".g-insuarance-pasporti").val() == "undefined" ||
        $(".g-insuarance-pasporti").val() == "" || 
        typeof $(".g-insuarance-piradinomeri").val() == "undefined" ||
        $(".g-insuarance-piradinomeri").val() == "" || 
        typeof $(".g-insuarance-telefonis").val() == "undefined" ||
        $(".g-insuarance-telefonis").val() == "" 
    ){
       $(".g-insuarance-error").fadeIn();
       $("#insurance123").prop("checked", false);
    }else{
        $("#insurance123").prop("checked", true);
        $("#InsuarancePopupBox").modal("hide"); 
    }
});

//.MobileMenuDiv left0 OpenMenu

$(document).on('hidden.bs.modal', '#InsuarancePopupBox', function () {
    if(
        typeof $(".g-insuarance-damzgvevi").val() == "undefined" ||
        $(".g-insuarance-damzgvevi").val() == "" || 
        typeof $(".g-insuarance-dazgveuli").val() == "undefined" ||
        $(".g-insuarance-dazgveuli").val() == "" || 
        typeof $(".g-insuarance-misamarti").val() == "undefined" ||
        $(".g-insuarance-misamarti").val() == "" || 
        typeof $(".g-insuarance-dabtarigi").val() == "undefined" ||
        $(".g-insuarance-dabtarigi").val() == "" || 
        typeof $(".g-insuarance-pasporti").val() == "undefined" ||
        $(".g-insuarance-pasporti").val() == "" || 
        typeof $(".g-insuarance-piradinomeri").val() == "undefined" ||
        $(".g-insuarance-piradinomeri").val() == "" || 
        typeof $(".g-insuarance-telefonis").val() == "undefined" ||
        $(".g-insuarance-telefonis").val() == "" 
    ){
       $("#insurance123").prop("checked", false);
    }else{
        $("#insurance123").prop("checked", true);
    }
});

        
$(document).ready(function(){
    window.addEventListener("scroll", function (event) {
        var scroll = this.scrollY;
        if(scroll>=5){
            $(".HeaderDiv").css({"position":"fixed", "top":"0px", "z-index":"1001" });
        }else{
            $(".HeaderDiv").css({"position":"static"});
        }
    });
});

$(document).on("change", ".terms-conditions-buy", function(){
    var check = $(this).prop("checked");
    if(check==true){
        $(".g-buyButtonx").css("opacity", "1");
        $(".g-buyButtonx").attr("onclick", "$('.CartBuyDiv').slideDown()");
    }else{
        $(".g-buyButtonx").css("opacity", "0.8");
        $(".g-buyButtonx").attr("onclick", "");
        $('.CartBuyDiv').slideUp();
    }
});