var _SlideshowTransitions = [
    {$Duration:1000,$Opacity:2}
];
jQuery(document).ready(function ($) {
    var _CaptionTransitions = [];
    _CaptionTransitions["A"] = {$Duration:800,$FlyDirection:8,$Easing:{$Top:$JssorEasing$.$EaseInOutSine},$ScaleVertical:0.6,$Opacity:2}
    var options = {
        $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
        $SlideDuration: 1200,
        $AutoPlay: false,
        $AutoPlayInterval: 3000,   
        $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
            $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
            $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
            $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
            $ShowLink: true,                                //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
            $ContentMode: false                              //Whether to trait content as slide, otherwise trait an image as slide
        },                       //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
        $DirectionNavigatorOptions: {
            $Class: $JssorDirectionNavigator$,              //[Requried] Class to create direction navigator instance
            $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
            $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
            $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
        },
        $CaptionSliderOptions: {                            //[Optional] Options which specifies how to animate caption
            $Class: $JssorCaptionSlider$,                   //[Required] Class to create instance to animate caption
            $CaptionTransitions: _CaptionTransitions,       //[Required] An array of caption transitions to play caption, see caption transition section at jssor slideshow transition builder
            $AutoCenter: 1,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value 
            $PlayInMode: 3,                                 //[Optional] 0 None (no play), 1 Chain (goes after main slide), 3 Chain Flatten (goes after main slide and flatten all caption animations), default value is 1
            $PlayOutMode: 1                                 //[Optional] 0 None (no play), 1 Chain (goes before main slide), 3 Chain Flatten (goes before main slide and flatten all caption animations), default value is 1
        }
    };
    var jssor_slider1 = new $JssorSlider$("slider2", options);
    //responsive code begin
    // function ScaleSlider() {
    //     var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
    //     if (parentWidth)
    //         jssor_slider1.$SetScaleWidth(parentWidth);
    //     else
    //         window.setTimeout(ScaleSlider, 30);
    // }
    //Scale slider immediately
    // ScaleSlider();
    // if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
    //     $(window).bind('resize', ScaleSlider);
    // }
    //responsive code end
});