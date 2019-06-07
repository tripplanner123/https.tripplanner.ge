$(function() {

    //.. Responsive menu
    var show_rm = false;
    $("#rm").click(function(){
        rm();
    });
    // show responsive menu
    function rm(){
       // rmh();
        if(!show_rm){
            $("#menu").attr("id","responsive-menu");
            $("#full-content").animate({"left":"260px"});
            show_rm = true;
        } else {
            $("#responsive-menu").attr("id","menu");
            $("#full-content").animate({"left":"0px"});
            show_rm = false;
        }
    }
    // rm-header height function
    /*function rmh(){
        $("#rmh").css("height",$("#header").innerHeight());
    }
    rmh();*/
    $("#responsive-menu").attr("id","menu");
    // fix full-content on resize
    $(window).resize(function(){
        if($(window).outerWidth() > 1200 && show_rm != false){
            rm();
            $("#header #menu.menu ul li").find("ul").removeClass("active");
        }
    });
    // rm sub menu Toggle
    $("#header").on("click","#responsive-menu li", function(){
        $(this).find("ul").toggleClass("active");
    });

    // .. Lang Selector
    function rl(){
        if($(window).outerWidth() <= 1200){
            $("#lang").addClass("lg");
        } else {
            $("#lang").removeClass("lg");
        }
    }

    rl();

    $(window).resize(function(){
        rl();
    });
    //lang Toggle
    $("#header").on("click","#lang.lg", function(){
        $(this).find("ul").toggleClass("active");
    });

    // .. Filter Dropdown Don't Close On Click
    $("#filter .select-items .dropdown-menu").on('click', function (e) {
        e.stopPropagation();
    });

});

$(window).load(function(){
  
    //.. Footer bottom
    function footer_bottom(){
        var windowHeight = $(window).outerHeight();
        var siteHeight = $("#wrapper-outerheight").outerHeight();
        var footerHeight = $("#footer").outerHeight();
        var position = 0;

        if (windowHeight > (siteHeight + footerHeight)) {
            position = windowHeight - siteHeight - footerHeight;
        }

        $("#footer").css("position", "relative").css("top", position);
    }
    footer_bottom();
    
});