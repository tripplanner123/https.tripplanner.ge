var Config = {
    website: "https://tripplanner.ge/"
};

Date.prototype.yyyymmdd = function() {
  var mm = this.getMonth() + 1;
  var dd = this.getDate();

  return [this.getFullYear()+"-",
          (mm>9 ? '' : '0') + mm + "-",
          (dd>9 ? '' : '0') + dd
         ].join('');
};

function g_htmlspecialchars(str) {
    var map = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        "\"": "&quot;",
        "'": "&#39;" // ' -> &apos; for XML only
    };
    return str.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function g_htmlspecialchars_decode(str) {
    var map = {
        "&amp;": "&",
        "&lt;": "<",
        "&gt;": ">",
        "&quot;": "\"",
        "&#39;": "'"
    };
    return str.replace(/(&amp;|&lt;|&gt;|&quot;|&#39;)/g, function(m) { return map[m]; });
}

function g_htmlentities(str) {
    var textarea = document.createElement("textarea");
    textarea.innerHTML = str;
    return textarea.innerHTML;
}

function g_htmlentities_decode(str) {
    var textarea = document.createElement("textarea");
    textarea.innerHTML = str;
    return textarea.value;
}

$(document).on("click",".profile-edit-button", function(){
    $(".MaterialForm input").removeClass("gErrorRedLine");
    $(".MaterialForm .gErrorText").text("").fadeOut();

    var input_lang = $("#input_lang").val();
    var firstname = $(".profile-first-name").val();
    var lastname = $(".profile-last-name").val();
    var idnumber = $(".profile-id-number").val();
    var birthday = $(".profile-birthday").val();
    var mobilenumber = $(".profile-mobile").val();
    var email = $(".profile-email").val();
   
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"editprofile", 
            input_lang:input_lang, 
            firstname:firstname,                  
            lastname:lastname,                  
            idnumber:idnumber,                  
            birthday:birthday,                  
            mobilenumber:mobilenumber,                  
            email:email                
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        var errorFields = obj.Error.errorFields;
        if(obj.Error.Code==1){            
            if(errorFields[0]=="popupbox"){
                $("#ErrorModal .modal-dialog .modal-content .modal-body .Text").html(obj.Error.Text);
                $("#ErrorModal").modal("show");
            }else{
                for (var i = errorFields.length - 1; i >= 0; i--) {
                    $("."+errorFields[i]+" input").addClass("gErrorRedLine");
                    $("."+errorFields[i]+" .gErrorText").text(obj.Error.Text).fadeIn("slow");
                }
            }
        }else{
            if(errorFields[0]=="popupbox"){
                $("#SuccessModal .modal-dialog .modal-content .modal-body .Text").html(obj.Success.Text);
                $("#SuccessModal").modal("show");

                setTimeout(function(){
                    location.reload();
                }, 1500);
            }
        }
    });
});

$(document).on("change", ".profile-photo", function(){

    var errorImageText = $(this).attr("data-errorImage"); 

    function isImage(filename) {
        var parts = filename.split('.');
        var ext = parts[parts.length - 1];

        switch (ext.toLowerCase()) {
            case 'jpg':
            case 'gif':
            case 'bmp':
            case 'png':
            return true;
        }
        return false;
    }

    var file = $(".profile-photo");

    if (!isImage(file.val())) {
        $("#ErrorModal .modal-dialog .modal-content .modal-body .Text").html(errorImageText);
        $("#ErrorModal").modal("show");
        return false;
    }    
    
    $("#profile-photo-form").submit();
});


$(document).on("click", ".removeProfilePhoto", function(){
    var input_lang = $("#input_lang").val()
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"removeProfileImage", 
            input_lang:input_lang                 
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
            $("#ErrorModal .modal-dialog .modal-content .modal-body .Text").html(obj.Error.Text);
            $("#ErrorModal").modal("show");
        }else{
            setTimeout(function(){
                location.reload()
            }, 1500);
        }
    });
});

$(document).on("click",".RegistrationButton", function(){
    $(".MaterialForm input").removeClass("gErrorRedLine");
    $(".MaterialForm .gErrorText").text("").fadeOut();

    var CSRF_token = $('meta[name=CSRF_token]').attr("value");
    var input_lang = $("#input_lang").val();
    var firstname = $(".first-name").val();
    var lastname = $(".last-name").val();
    var idnumber = $(".id-number").val();
    var birthday = $(".birthday").val();
    var mobilenumber = $(".mobile-number").val();
    var email = $(".email-address").val();
    var password = $(".user-password").val();
    var passwordConfirm = $(".password-confirm").val();
    var capchacode = $(".captcha-code").val();
    var termsCondi = ($(".terms-conditions").is(':checked')) ? "true" : "false";
    $(".captcha-code").val('');

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"registernewuser", 
            input_lang:input_lang, 
            firstname:firstname,                  
            lastname:lastname,                  
            idnumber:idnumber,                  
            birthday:birthday,                  
            mobilenumber:mobilenumber,                  
            email:email,                  
            password:password,                  
            passwordConfirm:passwordConfirm,                  
            capchacode:capchacode,                  
            termsCondi:termsCondi,                  
            token:CSRF_token                  
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
            $("#captcha").attr("src", "_modules/captcha/captchaImage.php");
            var errorFields = obj.Error.errorFields;
            if(errorFields[0]=="popupbox"){
                $("#ErrorModal .modal-dialog .modal-content .modal-body .Text").html(obj.Error.Text);
                $("#ErrorModal").modal("show");
            }else{
                for (var i = errorFields.length - 1; i >= 0; i--) {
                    $("."+errorFields[i]+" input").addClass("gErrorRedLine");
                    $("."+errorFields[i]+" .gErrorText").text(obj.Error.Text).fadeIn("slow");
                }
            }
        }else{
            $(".MaterialForm input").val("");
            $("#SuccessModal .modal-dialog .modal-content .modal-body .Text").html(obj.Success.Text);
            $("#SuccessModal").modal("show");
            $(".terms-conditions").click();
            setTimeout(function(){
                location.href = '/'+input_lang+'/profile#EditProFileLink';
            }, 2500);
        }
    });
});

$(document).on("click",".loginButtonTri", function(){
    $(".MaterialForm input").removeClass("gErrorRedLine");
    $(".MaterialForm .gErrorText").text("").fadeOut();

    var input_lang = $("#input_lang").val();
    var login = $(".login-email").val();
    var password = $(".login-password").val();
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"logintry", 
            input_lang:input_lang,               
            login:login,               
            password:password,
            token:CSRF_token                
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
           var errorFields = obj.Error.errorFields;
            if(errorFields[0]=="popupbox"){
                $("#ErrorModal .modal-dialog .modal-content .modal-body .Text").html(obj.Error.Text);
                $("#ErrorModal").modal("show");
            }else{
                for (var i = errorFields.length - 1; i >= 0; i--) {
                    $("."+errorFields[i]+" input").addClass("gErrorRedLine");
                    $("."+errorFields[i]+" .gErrorText").text(obj.Error.Text).fadeIn("slow");
                }
            }
        }else if(obj.Success.Code==1){
           location.href = "/"+input_lang+"/profile";
        }
    });
});

$(document).on("click",".toploginButtonTri", function(){
    $(".MaterialForm input").removeClass("gErrorRedLine");
    $(".MaterialForm .gErrorText").text("").fadeOut();

    var input_lang = $("#input_lang").val();
    var login = $(".top-login-email").val();
    var password = $(".top-login-password").val();
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");
    console.log(CSRF_token);

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"logintry", 
            top:true,
            input_lang:input_lang,               
            login:login,               
            password:password,                 
            token:CSRF_token                 
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
           var errorFields = obj.Error.errorFields;
            if(errorFields[0]=="popupbox"){
                $("#ErrorModal .modal-dialog .modal-content .modal-body .Text").html(obj.Error.Text);
                $("#ErrorModal").modal("show");
            }else{
                for (var i = errorFields.length - 1; i >= 0; i--) {
                    $("."+errorFields[i]+" input").addClass("gErrorRedLine");
                    $("."+errorFields[i]+" .gErrorText").text(obj.Error.Text).fadeIn("slow");
                }
            }
        }else if(obj.Success.Code==1){
           location.href = "/"+input_lang+"/profile";
        } 
    });
});

/* recover password */
$(document).on("click", ".recover-password-button", function(){
    $(".MaterialForm input").removeClass("gErrorRedLine");
    $(".MaterialForm .gErrorText").text("").fadeOut();

    var input_lang = $("#input_lang").val();
    var email = $(".forget-email").val();

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"recoverStepOne", 
            input_lang:input_lang,                 
            email:email                 
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
            var errorFields = obj.Error.errorFields;
            if(errorFields[0]=="popupbox"){
                $("#ErrorModal .modal-dialog .modal-content .modal-body .Text").html(obj.Error.Text);
                $("#ErrorModal").modal("show");
            }else{
                for (var i = errorFields.length - 1; i >= 0; i--) {
                    $("."+errorFields[i]+" input").addClass("gErrorRedLine");
                    $("."+errorFields[i]+" .gErrorText").text(obj.Error.Text).fadeIn("slow");
                }
            }
        }else{

            $(".forget-secrite-group").fadeIn();
            $(".forget-secrite-box input").addClass("gErrorRedLine");
            $(".forget-secrite-box .gErrorText").text(obj.Success.Text).fadeIn("slow");  
            $(".recover-password-button").removeClass("recover-password-button").addClass("recover-password-button-two");
        }
    });
});

$(document).on("click", ".recover-password-button-two", function(){
    $(".MaterialForm input").removeClass("gErrorRedLine");
    $(".MaterialForm .gErrorText").text("").fadeOut();

    var input_lang = $("#input_lang").val();
    var email = $(".forget-email").val();
    var secrite = $(".forget-secrite").val();

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"recoverStepTwo", 
            input_lang:input_lang,                 
            email:email,                
            secrite:secrite                
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
            var errorFields = obj.Error.errorFields;
            if(errorFields[0]=="popupbox"){
                $("#ErrorModal .modal-dialog .modal-content .modal-body .Text").html(obj.Error.Text);
                $("#ErrorModal").modal("show");
            }else{
                for (var i = errorFields.length - 1; i >= 0; i--) {
                    $("."+errorFields[i]+" input").addClass("gErrorRedLine");
                    $("."+errorFields[i]+" .gErrorText").text(obj.Error.Text).fadeIn("slow");
                }
            }
        }else{
            $(".MaterialForm input").val("");
            $("#SuccessModal .modal-dialog .modal-content .modal-body .Text").html(obj.Success.Text);
            $("#SuccessModal").modal("show");
        }
    });
});


$(document).on("click",".contact-send-button", function(){
    $(".MaterialForm input").removeClass("gErrorRedLine");
    $(".MaterialForm .gErrorText").text("").fadeOut();

    var input_lang = $("#input_lang").val();
    var firstname = $(".contact-firstname").val();
    var lastname = $(".contact-lastname").val();
    var email = $(".contact-email").val();
    var mobilenumber = $(".contact-mobile").val();
    var comment = $(".contact-comment").val();
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");
    
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"contactus", 
            input_lang:input_lang, 
            firstname:firstname,                  
            lastname:lastname,                  
            email:email,                  
            mobilenumber:mobilenumber,                  
            comment:comment, 
            token:CSRF_token                 
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
            var errorFields = obj.Error.errorFields;
            if(errorFields[0]=="popupbox"){
                $("#ErrorModal .modal-dialog .modal-content .modal-body .Text").html(obj.Error.Text);
                $("#ErrorModal").modal("show");
            }else{
                for (var i = errorFields.length - 1; i >= 0; i--) {
                    $("."+errorFields[i]+" input").addClass("gErrorRedLine");
                    $("."+errorFields[i]+" .gErrorText").text(obj.Error.Text).fadeIn("slow");
                }
            }
        }else{
            $(".MaterialForm input").val("");
            $("#SuccessModal .modal-dialog .modal-content .modal-body .Text").html(obj.Success.Text);
            $("#SuccessModal").modal("show");
        }
    });
});

$(document).on("click",".profile-edit-password-button", function(){
    $(".MaterialForm input").removeClass("gErrorRedLine");
    $(".MaterialForm .gErrorText").text("").fadeOut();

    var input_lang = $("#input_lang").val();
    var currentpassword = $(".profile-currentpassword").val();
    var newpassword = $(".profile-newpassword").val();
    var comfirmpassword = $(".profile-comfirmpassword").val();
    
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"updatepassword", 
            input_lang:input_lang, 
            currentpassword:currentpassword,                  
            newpassword:newpassword,                  
            comfirmpassword:comfirmpassword                
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
            var errorFields = obj.Error.errorFields;
            if(errorFields[0]=="popupbox"){
                $("#ErrorModal .modal-dialog .modal-content .modal-body .Text").html(obj.Error.Text);
                $("#ErrorModal").modal("show");
            }else{
                for (var i = errorFields.length - 1; i >= 0; i--) {
                    $("."+errorFields[i]+" input").addClass("gErrorRedLine");
                    $("."+errorFields[i]+" .gErrorText").text(obj.Error.Text).fadeIn("slow");
                }
            }
        }else{
            $(".MaterialForm input").val("");
            $("#SuccessModal .modal-dialog .modal-content .modal-body .Text").html(obj.Success.Text);
            $("#SuccessModal").modal("show");
        }
    });
});

var updateDataMobile = function(){
    $(".mobile-placesbox").html("...");
    var input_lang = $("#input_lang").val();
    
    var catIds = new Array();    
    $(".catbox").each(function(){
        if($(this).hasClass("active")){
            catIds.push($(this).attr("data-id"));
        }
    }); 
    catIds = JSON.stringify(catIds);

    var regionList = $("#mobile-regions").val();
    // regionList = JSON.stringify(regionList);

    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"loadPlacesMobile", 
            input_lang:input_lang, 
            categoryList:catIds,
            regionList:regionList             
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
            $(".mobile-placesbox").html("");
        }else{
           $(".mobile-placesbox").html(obj.Success.Regions);
        }
    });
};

var updateData = function(){
    //$(".CheckboxLists").html("...");
    var input_lang = $("#input_lang").val();
    var catIds = new Array();
    
    $(".catbox").each(function(){
        if($(this).hasClass("active")){
            catIds.push($(this).attr("data-id"));
        }
    }); 
    catIds = JSON.stringify(catIds);

    $(".CheckBoxItem[data-region]").hide();
    $(".Item[data-region]").hide();
    if($(".LocationDropDown1 .Item .TripCheckbox:checked").length<=0){
        $(".CheckBoxItem[data-region]").show();
        $(".Item[data-region]").show();
    }

    $(".LocationDropDown1 .Item .TripCheckbox").each(function(){
        if(this.checked){
            var mus = (typeof $(".catbox[data-id='108'] .CheckedItem").attr("style") !=="undefined") ? $(".catbox[data-id='108'] .CheckedItem").attr("style") : 'block';
            var nat = (typeof $(".catbox[data-id='107'] .CheckedItem").attr("style") !=="undefined") ? $(".catbox[data-id='107'] .CheckedItem").attr("style") : 'block';
            var cul = (typeof $(".catbox[data-id='105'] .CheckedItem").attr("style") !=="undefined") ? $(".catbox[data-id='105'] .CheckedItem").attr("style") : 'block';
            var win = (typeof $(".catbox[data-id='106'] .CheckedItem").attr("style") !=="undefined") ? $(".catbox[data-id='106'] .CheckedItem").attr("style") : 'block';

            $(".CheckBoxItem[data-region='"+$(this).attr("data-id")+"']").each(function(e){
                if(mus=="display: none;" && this.parentNode.classList[1]=="gg_musiams"){
                    console.log("shemovida 1");
                }else if(nat=="display: none;" && this.parentNode.classList[1]=="gg_natural"){
                    console.log("shemovida 2");
                }else if(cul=="display: none;" && this.parentNode.classList[1]=="gg_calture"){
                    console.log("shemovida 3");
                }else if(win=="display: none;" && this.parentNode.classList[1]=="gg_wine"){
                    console.log("shemovida 4");
                }else{
                    var id = $(this).attr("data-region");  
                    $(this).show();
                    $(".Item[data-region='"+id+"']").show(); 
                }                
            });
        }
    });
    
};

var g_countOngoingTour = function(crew, price_sedan, guest_sedan, price_minivan, price_minibus, price_bus, tour_margin, child_ages, cuisune, ticket, hotel, guide, tour_income_margin=null){
    var perprice = 0;
    var totalprice = 0;
    var cuisune_price = 0;
    var ticket_price = 0;

    var sedanMax = productPrices.sedan.p_ongoing_max_crowd;
    var vanMax = productPrices.minivan.p_ongoing_max_crowd;
    var miniBusMax = productPrices.minibus.p_ongoing_max_crowd;
    var busMax = productPrices.bus.p_ongoing_max_crowd;

    var totalCrew = parseInt(crew) + parseInt(child_ages.length) + parseInt($(".tour-child-number-under").val());
    
    // console.log(productPrices.sedan.p_ongoing_max_crowd);
    var outTotalPrice = 0;
    /* new count start */
    if(totalCrew<=sedanMax){// sedan
        if(totalCrew<=guest_sedan){// crew <= admin user sedan 
            var bepx = Math.ceil((price_sedan * tour_margin) / 100); 
            outTotalPrice = price_sedan - bepx;
        }else{
            outTotalPrice = price_sedan;
        }
    }else if(totalCrew>sedanMax && totalCrew<=vanMax){//minivan
        outTotalPrice = price_minivan;
    }else if(totalCrew>vanMax && totalCrew<=miniBusMax){//minibus
        outTotalPrice = price_minibus;
    }else if(totalCrew>miniBusMax){// bus
        var howManyBusNeed = Math.ceil(totalCrew / busMax);
        outTotalPrice = price_bus * howManyBusNeed;
    }
    /* new count end */


    /* additional info start */
    let adults = parseInt(crew);
    let child6 = parseInt(child_ages.length);
    let child0 = parseInt($(".tour-child-number-under").val());
    var aditionalprice = guide;
    // adult prices
    aditionalprice += (hotel * adults);
    aditionalprice += (cuisune * adults);
    aditionalprice += (ticket * adults);
    // child 6-12 prices
    aditionalprice += ((hotel / 2) * child6);
    aditionalprice += ((cuisune / 2) * child6);
    aditionalprice += ((ticket / 2) * child6); 
    // child 0-5
    // free
    /* additional info end */

    /* change additional service prices START*/
    let hotelPrice = 0;
    hotelPrice += (hotel * adults);
    hotelPrice += ((hotel / 2) * child6);
    
    let cuisunePrice = 0;
    cuisunePrice += (cuisune * adults);
    cuisunePrice += ((cuisune / 2) * child6); 
    
    let ticketPrice = 0;
    ticketPrice += (ticket * adults);
    ticketPrice += ((ticket / 2) * child6);
    
    $("#hotelPrice__").html(totalCrew+"x");
    $("#cuisunePrice__").html(totalCrew+"x");
    $("#ticketPrice__").html(totalCrew+"x");
    $("#gidi__").html(totalCrew+"x");

    
    $("#hotelPrice").attr("data-gelprice",hotelPrice);
    $("#cuisunePrice").attr("data-gelprice",cuisunePrice);
    $("#ticketPrice").attr("data-gelprice",ticketPrice);
    var usd = parseFloat($("#g-cur-exchange-usd").val());
    var eur = parseFloat($("#g-cur-exchange-eur").val());
    var exchange_cur = 1;
    var cur = "<i>A</i>";

    if($("#g-cur__").val()=="usd"){
        exchange_cur = usd; 
        cur = "$";
    }else if($("#g-cur__").val()=="eur"){
        exchange_cur = eur; 
        cur = "&euro;";
    }


    $("#hotelPrice").html(Math.round(hotelPrice / exchange_cur)+cur);
    $("#cuisunePrice").html(Math.round(cuisunePrice / exchange_cur)+cur);
    $("#ticketPrice").html(Math.round(ticketPrice / exchange_cur)+cur);
    /* change additional service prices END*/

    
    var theTotalPriceForPerPerson = parseInt((outTotalPrice + aditionalprice) / totalCrew);
    var theTotapPrice = parseInt(outTotalPrice + aditionalprice);

    // console.log(theTotalPriceForPerPerson + " -" + tour_income_margin+"-");

    var incomePricePerPerson = 0;
    var incomePrice = 0;
    if(tour_income_margin!=null && tour_income_margin!="" && !isNaN(tour_income_margin)){
        tour_income_margin=parseInt(tour_income_margin);
        incomePricePerPerson = Math.round(theTotalPriceForPerPerson * tour_income_margin / 100);
        incomePrice = Math.round(theTotapPrice * tour_income_margin / 100);
    }

    $("#packageprice").attr("data-gelprice", (theTotalPriceForPerPerson + incomePricePerPerson));
    $("#packageprice").html(Math.round((theTotalPriceForPerPerson + incomePricePerPerson) / exchange_cur)+cur);
    $(".gelprice").attr("data-gelprice", Math.round(theTotapPrice + incomePrice));
    $(".gelprice").html(Math.round((theTotapPrice + incomePrice) / exchange_cur)+cur);

    $(".QuantityButton").attr("disabled", false);
};

$(document).on("click", ".catbox", function(){
    let cattohide = $(this).attr("data-cattodelete");

    if($(this).hasClass("active")){
        $(this).removeClass("active");
        $(".CheckedItem", this).hide();
        $("."+cattohide+" .CheckBoxItem").hide();
    }else{
        $(this).addClass("active");
        $(".CheckedItem", this).show();
        $("."+cattohide+" .CheckBoxItem").hide();

        $(".LocationDropDown1 .TripCheckbox").each(function(){
            if($(this).is(':checked')){
                var ids = $(this).attr("data-id");
                $("."+cattohide+" .CheckBoxItem[data-region='"+ids+"']").show();
            }
        });
    }
    // updateData();
    


    updateDataMobile();
});

// $(document).on("mouseover", ".CheckBoxItem label", function(){
//     var imgurl = $(".LoadImage", this).attr("data-image");
//     var loaded = $(".LoadImage", this).attr("data-loaded");
//     if(typeof imgurl !== "undefined" && loaded!="true"){
//         var out = "<div style=\"background-image: url('"+imgurl+"'); width:100%; height:180px; background-size: cover;\"></div>";
//         $(".LoadImage", this).html(out);
//         $(".LoadImage", this).attr("data-loaded","true");
//     }
// });

$(document).on("keyup", "#g-search-input", function(){
    var input_lang = $("#input_lang").val();
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");
    var key = $(this).val();

    $("#g-search-result").html("...");
    $("#g-search-count-result").html(0);
    $("#g-search-count-blog").html(0);
    $("#g-search-count-tours").html(0);
    $("#g-search-count-places").html(0);
    if(typeof key !== "undefined" && key.length >= 4){
        $.ajax({
            type: "POST",
            url: Config.website+input_lang+"/?ajax=true",
            data: { 
                type:"searchkey", 
                input_lang:input_lang, 
                token:CSRF_token,
                key:key             
            } 
        }).done(function( msg ) {
            var obj = $.parseJSON(msg);
            if(obj.Error.Code==1){
                $("#g-search-result").html("");
            }else{
               $("#g-search-count-result").html(obj.Success.count);
               $("#g-search-result").html(obj.Success.output);
               $("#g-search-count-tours").html(obj.Success.catalogs_count);
               $("#g-search-count-blog").html(obj.Success.pages_count);
               $("#g-search-count-places").html(obj.Success.catalogs_count2);
            }
        }); 
    }
});

$(document).on("click", ".invoicePay", function(){
    var input_lang = $("#input_lang").val();
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");
    
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"invoicePayment", 
            input_lang:input_lang,          
            token:CSRF_token          
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
            alert("error #303");
        }else{
          location.href= "/"+input_lang+"/profile#myorders"; 
        }
    }); 
});
 
$(document).on("click", ".g-pickup-button", function(){
    var doubleway = $(this).attr("data-doubleway");
    var modaltitle = $(this).attr("data-modaltitle");
    var pick1 = $(this).attr("data-pick1");
    var pick2 = $(this).attr("data-pick2");
    var cartid = $(this).attr("data-cartid");
    var pickplacevalue1 = $(this).attr("data-pickplacevalue1");
    var pickplacevalue2 = $(this).attr("data-pickplacevalue2");
    $("#pick1").val(pickplacevalue1);
    $("#pick2").val(pickplacevalue2);

    $("#g-pickplace-modal").modal("show");
    $("#g-pickplace-modal .modal-dialog .modal-content").css("min-height", "auto");
    $("#g-pickplace-modal .modal-dialog .modal-content .modal-header .modal-title").html(modaltitle);
    //$("#pick1").attr("placeholder", pick1);
    $(".savePickUp").attr("data-cartid", cartid);
    if(doubleway=="true"){
        $("#pick2").show();
    }else{
        $("#pick2").hide();
    }
    // $("#g-message-modal .modal-body").html(doubleway);
    console.log(doubleway);
});

$(document).on("click", ".savePickUp", function(){
    var cartid = $(this).attr("data-cartid");
    var input_lang = $("#input_lang").val();
    var pick1 = $("#pick1").val();
    var pick2 = $("#pick2").val();
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");
    $(".resultPickupsave").html("...");
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"savePickUp", 
            input_lang:input_lang,          
            pick1:pick1,          
            pick2:pick2,          
            cartid:cartid,
            token:CSRF_token          
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
            $(".resultPickupsave").html(obj.Error.Text);
        }else{
          $(".resultPickupsave").html(obj.Success.Text);
          setTimeout(function(){
            location.reload();
          },1500);
        }
    });
});


$(document).on("click", ".g-orders-load-more", function(){
    var loaded = parseInt($(this).attr("data-loaded"));
    $(this).attr("data-loaded", loaded+5);
    var CSRF_token = $('meta[name=CSRF_token]').attr("value");
    var input_lang = $("#input_lang").val();
    $.ajax({
        type: "POST",
        url: Config.website+input_lang+"/?ajax=true",
        data: { 
            type:"loadmoreorders", 
            input_lang:input_lang,             
            loaded:loaded,
            token:CSRF_token          
        } 
    }).done(function( msg ) {
        var obj = $.parseJSON(msg);
        if(obj.Error.Code==1){
            console.log(obj.Error.Text);
            $(".g-orders-load-more").hide();
        }else{
            if(obj.Success.Html!=""){
                $("#g-my-orders #loadedcontent").append(obj.Success.Html);
            }else{
                $(".g-orders-load-more").hide();
            }
        }
    });
});