<?php defined('DIR') OR exit;?>
<div class="InsidePagesHeader">
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_1.jpg');"></div>
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_2.jpg');"></div>
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_3.jpg');"></div>
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_4.jpg');"></div>
</div>
<?php
// echo "<pre>";
// print_r(get_defined_vars());
// echo "</pre>";

if($menuid==47 || $menuid==36){ // if it is Sight
?>
<div class="BlogInsidePage"> 
    <div class="container">
      <h1 class="BlogTitle"><?=$title?></h1>
      <div class="Description" style="margin-bottom: 80px;">
        <img src="https://tripplanner.ge/image.php?f=<?=$image1?>&w=710&h=770" width="100%" />
        <?=$description?>
      </div>
    </div>
  </div>
<?php 
}else{
?>
<div class="TripListPageDiv">
  <div class="TripListInsidePage"> 
    <div class="container"> 
      
      <div class="row row0">
        <div class="col s12">
          <div class="Breadcrumb"> 
            <a href="/<?=l()?>/home" class="Nolink"><?=menu_title(1)?></a>
              <span>></span>
            <a href="<?=href(61)?>"><?=menu_title(61)?></a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="ToursSliderDiv">
            <div class="BigImageSlide">
              <?php 
              for($i=1; $i<=10; $i++):
                $img = "image$i";
                if(!empty($$img)): 
              ?>
                  <div class="Image" style="background:url('https://tripplanner.ge/image.php?f=<?=$$img?>&w=1200&h=500');"></div>
              <?php 
                endif; 
              endfor;
              ?>
            </div>
            <div class="SmallImageSlide">
              <?php 
              for($i=1; $i<=10; $i++):
                $img = "image$i";
                if(!empty($$img)):
              ?>
                <div class="Image" style="background:url('https://tripplanner.ge/image.php?f=<?=$$img?>&w=82&h=80');"></div>
              <?php 
                endif; 
              endfor;
              ?>
            </div>
          </div>
        </div>
        <?php 
        if($menuid==36){
          $class = "col-sm-12";
        }else{
          $class = "col-sm-9 ColSm9";
        }
        ?>
        <div class="<?=$class?>">
          <div class="TripSinglePage">
            <div class="TripTitle"><?=$title?></div>
            <div class="TripBottomDiv">
              <div class="TabsMenu">
                <ul> 
                  <li class="active">
                    <a href="#Overview" aria-controls="home" role="tab" data-toggle="tab"><?=l("overview")?></a>
                  </li>
                  <li>
                    <a href="#TourDescription" aria-controls="profile" role="tab" data-toggle="tab"><?=l("tourdescription")?></a>
                  </li>
                  <li>
                    <a href="#TourIncludes" aria-controls="messages" role="tab" data-toggle="tab"><?=l("tourincludes")?></a>
                  </li>
                  <li>
                    <a href="#Mapid" aria-controls="settings" role="tab" data-toggle="tab"><?=l("map")?></a>
                  </li>
                </ul>
              </div>
              
              <div class="TabsContent tab-content">
                <div class="tab-pane active" id="Overview"> 
                  <?php 
                  $cat = explode(",", $categories);
                  $cat = (isset($cat[0])) ? (int)$cat[0] : 0;
                  $sql = "SELECT `title`,`image1` FROM `pages` WHERE `id`={$cat} AND `visibility`=1 AND `deleted`=0 AND `language`='".l()."'";
                  $catimage = db_fetch($sql);
                  $image1 = (isset($catimage["image1"])) ? $catimage["image1"] : '';
                  $title = (isset($catimage["title"])) ? $catimage["title"] : '';
                  

                  $reg = explode(",", $regions);                  
                  $sql = "SELECT `title` FROM `pages` WHERE `id` IN (".$regions.") AND `visibility`=1 AND `deleted`=0 AND `language`='".l()."'";
                  $region_list = db_fetch_all($sql);
                  ?>
                  
                  <div class="PlannerCategories">
                    <div class="row"> 
                      <div class="Item active">
                        <div class="MuseumIcon" style="background-image: url('<?=$image1?>');     background-position: top center; width: 70px;"></div>
                        <div class="Title"><?=$title?></div>  
                      </div> 
                    </div>
                  </div> 
                  
                  <div class="FiltItemsDiv">
                    <div class="row">
                      <div class="col-sm-12">
                        <?php foreach($region_list as $re): ?>
                        <div class="Item"><?=$re['title']?></div>
                        <?php endforeach; ?>
                        <!-- <div class="Item"><?=$postdate?></div> -->
                      </div> 
                    </div>  
                  </div>
                  
                  <div style="clear:both"></div>

                  <?=$overview?>  
                </div>
                <div class="tab-pane" id="TourDescription"><?=$description?></div>
                <div class="tab-pane" id="TourIncludes"><?=$includes?></div>
                <div class="tab-pane" id="Mapid">
                  <div class="SidebarSmallMap text-center" id="SidebarSmallMap">
                  MAP DIV
                  </div>
                </div>

              </div>
            </div>
          </div>      
        </div>

        <?php 
        if($menuid==36){
          $style = "style='display:none'";
        }else{
          $style = "";
        }
        ?>
        
        <div class="col-sm-3 ColSm3" <?=$style?>>
          <div class="TripSidebar">
            <div class="GreenSidebarDiv RightBackground ToursInsideSidebar">
              <div class="SidebarTitle"><?=l("orderdetails")?></div>
              <div class="FiltersDiv">
                <div class="col-sm-12 PaddingRight0 g-mobilePadding-15">
                  <div class="btn-group SearchFilterItem"> 
                      <div class="TripTogglebutton">
                        <span>
                          <div class="row">
                            <div class="col-sm-6 g-mobilehalf"><?=l("startdate")?></div>
                            <div class="col-sm-6 g-mobilehalf" style="position:relative;left:-19px;"><?=l("enddate")?></div>
                          </div>
                        </span>
                        <div class="input-group PositionRelative">
                        <input type="text" class="form-control DatePicker2" value="<?=date("Y-m-d", time()+172800)?>" readonly="readonly" />
                        <span class="input-group-addon TimeAddons">-</span>
                        <?php 
                        $newdates = time() + ((int)$total_dayes * 86400) + 172800;
                        ?>
                        <input type="text" class="form-control DatePicker" value="<?=date("Y-m-d", $newdates)?>" disabled="disabled" style="background-color: #fff" />
                        <span class="input-group-addon" onclick="$('.DatePicker2').focus()"><i class="fa fa-calendar"></i></span>
                      </div>
                      </div> 
                  </div>
                </div>
                
                <div class="col-sm-6">
                  <div class="btn-group SearchFilterItem"> 
                      <div class="TripTogglebutton">
                        <span class="Name1"><?=l("adults")?></span>
                        <div class="input-group PositionRelative"> 
                        <span class="Quantity Quantity2">
                          <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn QuantityButton btn-number"  data-type="minus" data-field="quant[2]">
                                      <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </span>
                                <input type="number" readonly="readonly" name="quant[2]" class="form-control tour-guest-number" value="1" min="1" max="100" pattern="\d*"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn QuantityButton btn-number" data-type="plus" data-field="quant[2]">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </span>
                            </div>
                        </span> 
                      </div>
                      </div> 
                  </div>
                </div>   

                <div class="col-sm-6">
                  <div class="btn-group SearchFilterItem g-tooltip" data-tooltip="<?=htmlentities(l("chilndernOngoing_05"))?>"> 
                      <div class="TripTogglebutton">
                        <span class="Name1"><?=l("underchildrenages")?></span>
                        <div class="input-group PositionRelative"> 
                          <span class="Quantity Quantity2">
                            <div class="input-group">
                                  <span class="input-group-btn">
                                      <button type="button" class="btn QuantityButton btn-number"  data-type="minus" data-field="quant[900]">
                                        <span class="glyphicon glyphicon-minus"></span>
                                      </button>
                                  </span>
                                  <input type="number" readonly="readonly" name="quant[900]" class="form-control tour-child-number-under" value="0" min="0" max="100" pattern="\d*" />
                                  <span class="input-group-btn">
                                      <button type="button" class="btn QuantityButton btn-number" data-type="plus" data-field="quant[900]">
                                          <span class="glyphicon glyphicon-plus"></span>
                                      </button>
                                  </span>
                              </div>
                          </span> 
                      </div>
                      </div> 
                  </div>
                </div>             

                <div class="col-sm-6">
                  <div class="btn-group SearchFilterItem g-tooltip" data-tooltip="<?=htmlentities(l("chilndernOngoing_612"))?>"> 
                      <div class="TripTogglebutton">
                        <span class="Name1"><?=l("childrenages")?></span>
                        <div class="input-group PositionRelative"> 
                          <span class="Quantity Quantity2">
                            <div class="input-group">
                                  <span class="input-group-btn">
                                      <button type="button" class="btn QuantityButton btn-number"  data-type="minus" data-field="quant[3]">
                                        <span class="glyphicon glyphicon-minus"></span>
                                      </button>
                                  </span>
                                  <input type="number" readonly="readonly" name="quant[3]" class="form-control tour-child-number" value="0" min="0" max="100" pattern="\d*"/>
                                  <span class="input-group-btn">
                                      <button type="button" class="btn QuantityButton btn-number" data-type="plus" data-field="quant[3]">
                                          <span class="glyphicon glyphicon-plus"></span>
                                      </button>
                                  </span>
                              </div>
                          </span> 
                      </div>
                      </div> 
                  </div>
                </div>

                <div class="col-sm-12 g-children-box">                 
                </div>

                <?php 
                $cur = "<i>A</i>"; 
                $cur_exchange = 1;

                if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="usd"){
                  $cur = "$"; 
                  $cur_exchange = (float)s("currencyusd");
                }else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="eur"){
                  $cur = "&euro;"; 
                  $cur_exchange = (float)s("courseeur");
                }

                if(!isset($_SESSION["CSRF_token"])){
                  $_SESSION["CSRF_token"] = md5(time());
                }

                ?>
                <form action="javascript:void(0)" method="post">
                <input type="hidden" name="cur" id="cur" value="<?=htmlentities($cur)?>" />
                <input type="hidden" name="cur_exchange" id="cur_exchange" value="<?=htmlentities($cur_exchange)?>" />
                <input type="hidden" name="CSRF_token" value="<?=$_SESSION["CSRF_token"]?>" />
                </form>
                <?php 
                  $kveba = (int)$cuisune_price1person;
                  $bileti = (int)$ticketsandother_price1person;
                  $sastumro = (int)$hotelpricefortour;
                  $gidi = (int)$guidepricefortour;
                  $aditionalprice = $kveba + $bileti + $sastumro + $gidi;
                  echo "<div style=\"clear:both\"></div>";
                  ?>
                  <div class="col-sm-12">
                    <div class="addd" style="background-color: transparent; width: 100%; display: block; padding-left: 20px;">

                      <?php if($sastumro>0): ?>
                      <div class="Item Item_2" style="padding-right: 0px;">
                        <div class="Icon HotelIcon"></div>
                          <li>
                            <label><?=l("hotel")?></label>
                            <i data-gelprice="<?=$sastumro?>" id="hotelPrice__" style="font-family: 'CenturyGothic'; float:right;">1x</i>
                          </li>
                      </div>
                      <?php endif; ?>

                      <?php if($kveba>0): ?>
                      <div class="Item Item_2" style="padding-right: 0px;">
                        <div class="Icon Cuisune"></div>
                          <li>
                            <label><?=l("cuisune")?></label>
                            <i data-gelprice="<?=$kveba?>" id="cuisunePrice__" style="font-family: 'CenturyGothic'; float:right;">1x</i>
                          </li>
                      </div>
                      <?php endif; ?>

                      <?php if($bileti>0): ?>
                      <div class="Item Item_2" style="padding-right: 0px;">
                        <div class="Icon Ticketx"></div>
                          <li>
                            <label><?=l("ticket")?></label>
                            <i data-gelprice="<?=$bileti?>" id="ticketPrice__" style="font-family: 'CenturyGothic'; float:right;">1x</i>
                          </li>
                      </div>
                      <?php endif; ?>

                      <?php if($gidi>0): ?>
                      <div class="Item Item_2" style="padding-right: 0px;">
                        <div class="Icon GuideIcon"></div>
                          <li>
                            <label><?=l("guide")?></label>
                            <i data-gelprice="<?=$gidi?>" id="gidi__" style="font-family: 'CenturyGothic'; float:right; visibility: hidden;">1x</i>
                          </li>
                      </div>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="col-sm-12 padding_0">                     
                <div class="IncuranceNewDiv"> 
                  <input class="TripNewCheckbox" type="checkbox" id="insurance123" />
                  <label for="insurance123">
                    <div class="FreeIncurance">+ <?=l("freeinsurance")?></div>
                  </label>
                </div>
              </div>
              <div style="clear: both"></div>
                <div class="col-sm-12">
                  <div class="btn-group PackageInfoDiv"> 
                    <div class="">
                      <label><?=l("costperperson")?></label>
                      <?php                   
                      $perpersonprice = g_ongoing_tour_one_person_price(1, $guest_sedan, $price_sedan, $tour_margin); 

                      $totalPerPersonPrice = (int)$perpersonprice + (int)$aditionalprice;
                      $totalPriceForAll = (int)$perpersonprice + (int)$aditionalprice;
                      
                      $incomePricePerPerson = 0;
                      $incomePrice = 0;
                      if($tour_income_margin){
                        $incomePricePerPerson = round($totalPerPersonPrice * (int)$tour_income_margin / 100);
                        $incomePrice = round($totalPriceForAll * (int)$tour_income_margin / 100);

                        // $incomePricePerPerson = round($incomePricePerPerson / $cur_exchange);
                        // $incomePrice = round($incomePrice / $cur_exchange);
                        
                      }

                      $theGelPrice__ = $totalPerPersonPrice + $incomePricePerPerson;
                      $theGelPriceCur__ = round(($totalPerPersonPrice + $incomePricePerPerson) / $cur_exchange)
                      ?>
                      <span id="packageprice" data-gelprice="<?=$theGelPrice__?>"><?=$theGelPriceCur__?><?=$cur?></span>
                    </div>
                  </div>
                </div>


              </div>


              <div class="TotalPriceDiv" style="margin-top: 10px;">
                <div class="col-sm-6">
                    <div class="Title">
                      <?=l("totalprice")?>:
                    </div>
                </div>

                <div class="col-sm-6 text-right ">
                      <div class="SumCount">
                        <?php 
                        $totaltheGelPrice__ = $totalPriceForAll + $incomePrice;
                        $totaltheGelPriceCur__ = round(($totalPriceForAll + $incomePrice) / $cur_exchange)
                        ?>
                        <span class="gelprice" data-gelprice="<?=$totaltheGelPrice__?>"><?=$totaltheGelPriceCur__?><?=$cur?></span>
                        <span class="hoverprice"></span>
                      </div>
                </div>

                <div class="col-sm-12 pull-right text-center productPageCartBox" style="margin-top: 25px;">
                  <?php 
                  if(isset($_SESSION["trip_user"])){
                  ?>
                    <a href="javascript:void(0)" class="GreenCircleButton_4 addCart g-visiable-button" data-inside="true" data-redirect="true" data-id="<?=$id?>" data-title="<?=l("message")?>" data-errortext="<?=l("error")?>"><?=l("buy")?></a>
                  <?php } ?>
                  <a href="javascript:void(0)" class="GreenCircleButton_4 addCart <?=(!empty($cartId)) ? 'active' : ''?>" data-inside="true" data-redirect="false" data-id="<?=$id?>" data-title="<?=l("message")?>" data-errortext="<?=l("error")?>"><span class="CartIcon"></span> <?=l("addtocart")?></a> 
                </div>

              </div>


            </div>
          </div>
        </div>

      </div>

      <div class="MoreBlogList">
        <div class="Title"><?=l("viewalso")?></div>        
        <div class="ToursList">
          <div class="row">               
            <?php 
            foreach (g_inside_tours_rand() as $item):
              $link = href(63,array(), l(), $item['id']);
            ?>
            <div class="col-sm-3">
              <div class="Item">
                <div class="TopInfo" onclick="location.href='<?=str_replace(array('"',"'"," "),"",$link)?>'">
                  <div class="Background" style="background:url('<?=$item['image1']?>');"></div>
                </div>
                <div class="BottomInfo" onclick="location.href='<?=str_replace(array('"',"'"," "),"",$link)?>'">
                  <div class="Title"><?=g_cut($item['title'], 40)?></div>
                  <div class="Day"><?=$item['day_count']?> <?=l("days")?></div>
                </div>
                <div class="Buttons">
                  <a href="javascript:void(0)" class="addCart<?=(!empty($item['cartId'])) ? ' active' : ''?>" data-id="<?=$item['id']?>" data-title="<?=l("wrongmessage")?>" data-errortext="<?=l("error")?>"><span class="CartIcon"></span> <?=l("addtocart")?></a>
                  <a href="<?=str_replace(array('"',"'"," "),"",$link)?>"><?=l('more')?></a>
                </div>
              </div>
            </div>
            <?php endforeach; ?>


          </div>
        </div> 
      </div>

    </div>
  </div>
</div>
<?php 
$Transport = g_listselect(40, false);
$productPrices = [];
foreach($Transport as $tra){
  if($tra["id"]==125){ //sedani
    $productPrices["sedan"]["p_ongoing_max_crowd"] = $tra["p_ongoing_max_crowd"];
  }else if($tra["id"]==126){ //minivan
    $productPrices["minivan"]["p_ongoing_max_crowd"] = $tra["p_ongoing_max_crowd"];
  }else if($tra["id"]==127){ //minibus
    $productPrices["minibus"]["p_ongoing_max_crowd"] = $tra["p_ongoing_max_crowd"];
  }else if($tra["id"]==220){ //bus
    $productPrices["bus"]["p_ongoing_max_crowd"] = $tra["p_ongoing_max_crowd"];
  }
}
?>

<script type="text/javascript">
  var productPrices = {
    sedan:{
      p_ongoing_max_crowd:parseFloat("<?=(float)$productPrices['sedan']['p_ongoing_max_crowd']?>")
    },
    minivan:{
      p_ongoing_max_crowd:parseFloat("<?=(float)$productPrices['minivan']['p_ongoing_max_crowd']?>")
    },
    minibus:{
      p_ongoing_max_crowd:parseFloat("<?=(float)$productPrices['minibus']['p_ongoing_max_crowd']?>")
    },
    bus:{
      p_ongoing_max_crowd:parseFloat("<?=(float)$productPrices['bus']['p_ongoing_max_crowd']?>")
    }
  };
</script>

<script type="text/javascript">
  var map;
  var infos = [];
function initMap() {
  var mapOptions = {
      zoom: 14,
      mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  map = new google.maps.Map(document.getElementById('SidebarSmallMap'), mapOptions);

  var directionsService = new google.maps.DirectionsService();
  var directionsDisplay = new google.maps.DirectionsRenderer();

  directionsDisplay.setMap(map);
  directionsDisplay.setOptions({ 
    polylineOptions: {
      strokeColor: "#12693b"
    }, 
    suppressMarkers: true 
  });

  var locations = [
    <?php 
    $mapsCoordinates = g_get_place_map_coordinates($places);
    foreach($mapsCoordinates as $v):
      if(empty($v['map_coordinates']) || $v['map_coordinates']==""){ continue; }
      $coords = explode(":", $v['map_coordinates']);
      if(!isset($coords[0]) || !isset($coords[1])){ continue; }
    ?>
    ['<?=htmlentities($v['title'])?>', <?=$coords[0]?>, <?=$coords[1]?>],
    <?php endforeach; ?>
  ];
  var bounds = new google.maps.LatLngBounds();
  var marker, i;
  var waypoints = [];
  for (i = 0; i < locations.length; i++){  
    if(locations[i][1]==0 || locations[i][2]==0){
      $("#map").hide();
      break;
    }

    waypoints.push({
        location: new google.maps.LatLng(locations[i][1], locations[i][2]),
        stopover: true
    });

    var contentString = '<div id="content">'+locations[i][0]+'</div>';

    var infowindow = new google.maps.InfoWindow();

    marker = new google.maps.Marker({
      position: new google.maps.LatLng(locations[i][1], locations[i][2]),
      map: map,
      // animation: google.maps.Animation.DROP,
      title: locations[i][0],
      icon:"/img/markerv2.png"
    });

    google.maps.event.addListener(marker,'click', (function(marker,contentString,infowindow){ 
        return function() {
            closeInfos();
            infowindow.setContent(contentString);
            infowindow.open(map,marker);
            infos[0]=infowindow;
        };
    })(marker,contentString,infowindow));  

    bounds.extend(marker.position);

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      console.log("zoom change try");
      // map.setZoom(7);
      map.fitBounds(bounds);
    });
  }



  if(locations.length >= 2){
    var start = new google.maps.LatLng(locations[0][1], locations[0][2]);
    var end = new google.maps.LatLng(locations[locations.length-1][1], locations[locations.length-1][2]);

    var request = {
      origin: start, 
      destination: end,
      travelMode: 'DRIVING',
      waypoints: waypoints,
      optimizeWaypoints: true
    };

    directionsService.route(request, function(result, status) {
      if (status == 'OK') {
        directionsDisplay.setDirections(result);


      }
    });
  }
  map.fitBounds(bounds);
}

function closeInfos(){
   if(infos.length > 0){
      infos[0].set("marker", null);
      infos[0].close();
      infos.length = 0;
   }
}

var countData = {
  price_sedan: parseInt("<?=$price_sedan?>"),
  guest_sedan: parseInt("<?=$guest_sedan?>"),
  price_minivan: parseInt("<?=$price_minivan?>"),
  price_minibus: parseInt("<?=$price_minibus?>"),
  price_bus: parseInt("<?=$price_bus?>"),
  tour_margin: parseInt("<?=$tour_margin?>"),
  tour_income_margin: parseInt("<?=$tour_income_margin?>"),
  tour_total_days: parseInt("<?=(int)$total_dayes?>"),
  cuisune: parseInt("<?=(int)$cuisune_price1person?>"),
  ticket: parseInt("<?=(int)$ticketsandother_price1person?>"),
  hotel: parseInt("<?=(int)$hotelpricefortour?>"),
  guide: parseInt("<?=(int)$guidepricefortour?>")
};

var todayDate = new Date().getDate();

$('.DatePicker2').datepicker({
  format: 'yyyy-mm-dd',
  ignoreReadonly: true,
  autoclose:true, 
  startDate: new Date(new Date().setDate(todayDate + 2)),
  language:'<?=l()?>'
});



$(document).on("change", ".DatePicker2", function(){
  let startDate = new Date($(this).val());                  
  let tour_dayes_times = parseInt(countData.tour_total_days) * 86400000;
  let tour_finish = startDate.getTime() + tour_dayes_times;
  
  var setTodate = new Date(new Date().setTime(tour_finish));
  $(".DatePicker").val(setTodate.yyyymmdd());
  return false;
});

$(document).on("change", ".tour-guest-number", function(){    
  let crew = parseInt($(this).val());  
  let children = parseInt($(".tour-child-number").val());  
  var child_ages = [];
  for (var i = 1; i <= children; i++) {
    child_ages.push(10);
  }

  g_countOngoingTour(crew, countData.price_sedan, countData.guest_sedan, countData.price_minivan, countData.price_minibus, countData.price_bus, countData.tour_margin, child_ages, countData.cuisune, countData.ticket, countData.hotel, countData.guide, countData.tour_income_margin);
});

$(document).on("change", ".tour-child-number", function(){

  let children = parseInt($(this).val());  
  var child_ages = [];
  let crew = parseInt($(".tour-guest-number").val()); 
  for (var i = 1; i <= children; i++) {
    child_ages.push(10);
  }
  g_countOngoingTour(crew, countData.price_sedan, countData.guest_sedan, countData.price_minivan, countData.price_minibus, countData.price_bus, countData.tour_margin, child_ages, countData.cuisune, countData.ticket, countData.hotel, countData.guide, countData.tour_income_margin);price_minivan
});

$(document).on("change", ".tour-child-number-under", function(){

  let children = parseInt($(".tour-child-number").val());  
  var child_ages = [];
  let crew = parseInt($(".tour-guest-number").val()); 
  for (var i = 1; i <= children; i++) {
    child_ages.push(10);
  }
  g_countOngoingTour(crew, countData.price_sedan, countData.guest_sedan, countData.price_minivan, countData.price_minibus, countData.price_bus, countData.tour_margin, child_ages, countData.cuisune, countData.ticket, countData.hotel, countData.guide, countData.tour_income_margin);
});

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeSTjMJTVIuJaIiFgxLQgvCRl8HJqo0qo&amp;callback=initMap"></script>
<?php } ?>