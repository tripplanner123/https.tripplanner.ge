<?php defined('DIR') OR exit;?>
<?php 
$g_categories_with_tour_count = g_categories_with_tour_count();
$g_places_with_tour_count = g_places_with_tour_count();
?>



<div class="InsidePagesHeader">
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_1.jpg');"></div>
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_2.jpg');"></div>
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_3.jpg');"></div>
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_4.jpg');"></div>
</div>



<div class="TripListPageDiv">
  <div class="TripListInsidePage">
    <div class="container">      

      <h3 class="PageTitle InsideTitle"><label><?=menu_title(63)?></label></h3>

      <div class="row row0">
        <div class="col s12">
          <div class="Breadcrumb"> 
            <a href="/<?=l()?>/home" class="Nolink"><?=menu_title(1)?></a>
              <span>&gt;</span>
            <a href="/<?=l()?>/ongoing-tours"><?=menu_title(63)?></a>
          </div>
        </div>
      </div>



      <div class="FiltersDiv">
        <div class="row row0">
          <a href="/<?=l()?>/ongoing-tours" class="AllToursButton" style="display:block; text-decoration: none;"><?=l("alltours")?> <div><?=(isset($items[0]["counted"])) ? $items[0]["counted"] : 0?></div></a>
		<div class="col-sm-4 ShowForMobile">     
        <input type="hidden" name="mobile-categories" id="mobile-categories" value="" />
        <div class="g-selector-mainbox">
          <div class="g-selector-title" data-defaulttext="<?=htmlentities(l("searchbycategories"))?>"><?php 
          $cat = array();
          if(isset($_GET["cat"]) && $_GET["cat"]!=""){
            $cat = explode(",",$_GET["cat"]); 
            $selectedCats = [];
            foreach ($g_categories_with_tour_count as $item):
              if(in_array($item["id"], $cat)){
                $selectedCats[] = $item["title"];
              }
            endforeach;
            echo implode(", ", $selectedCats);
          }else{
            echo l("searchbycategories");
          }
          ?></div>
          <div class="g-mselector-box">
            <?php 
            foreach ($g_categories_with_tour_count as $item):
            ?>
            <label><?=$item["title"]?> <input type="checkbox" name="mselector[]" value="<?=$item["id"]?>" class="mselector" data-attached="#mobile-categories" data-val="<?=htmlentities($item["title"])?>" <?=(in_array($item["id"], $cat)) ? 'checked="checked"' : ''?> /></label>
            <?php 
            endforeach;
            ?>
          </div>
        </div>
		</div>

		<div class="col-sm-4 ShowForMobile">

      <input type="hidden" name="mobile-regions" id="mobile-regions" value="" />
        <div class="g-selector-mainbox">
          <div class="g-selector-title" data-defaulttext="<?=htmlentities(l("searchbyregions"))?>"><?php
          $reg = array();
          if(isset($_GET["reg"]) && $_GET["reg"]!=""){
            $reg = explode(",",$_GET["reg"]); 
            $selectedReg = [];
            foreach ($g_places_with_tour_count as $item):
              if(in_array($item["id"], $reg)){
                $selectedReg[] = $item["title"];
              }
            endforeach;
            echo implode(", ", $selectedReg);
          }else{
            echo l("searchbyregions");
          }?></div>
          <div class="g-mselector-box">
            <?php 
            foreach ($g_places_with_tour_count as $item):
            ?>
            <label><?=$item["title"]?> <input type="checkbox" name="mselector2[]" value="<?=$item["id"]?>" class="mselector2" data-attached="#mobile-regions" data-val="<?=htmlentities($item["title"])?>" <?=(in_array($item["id"], $reg)) ? 'checked="checked"' : ''?> /></label>
            <?php 
            endforeach;
            ?>
          </div>
        </div>

		</div>
		  
		  
		  
          <div class="col-sm-3 HideForMobile">
            <div class="btn-group SearchFilterItem"> 
                <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
                  <span class="Name1"><?=l("searchbycategories")?></span>
                  <label class="Name2 CatagoryName"></label>
                </div>
                <div class="dropdown-menu CategoriesDropDown"> 
                    <?php
                    foreach ($g_categories_with_tour_count as $v):
                    ?>
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" data-id="<?=$v['id']?>" value="<?=htmlentities($v['title'])?>" name="layout" id="Cat<?=$v['id']?>">
                      <label class="pull-left Text" for="Cat<?=$v['id']?>">
                        <div class="Info">
                          <div class="Image <?=$v['id']?>" style="background-image: url('<?=$v['image1']?>');"></div>
                          <div class="Title"><?=$v['title']?></div>
                          <div class="Count"><?=$v['tour_counted']?></div>
                        </div>
                      </label> 
                    </div>
                     <?php endforeach; ?>
                </div>
            </div>
          </div>

          <div class="col-sm-3 HideForMobile">
            <div class="btn-group SearchFilterItem RegiosSearchDropDown"> 
                <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
                  <span class="Name1"><?=l("searchbyregions")?></span>
                  <label class="Name2 LocationName InpueValue2 RegiosName"></label>
                </div>

                <div class="dropdown-menu LocationDropDown LocationDropDown2"> 
                    <?php 
                    foreach ($g_places_with_tour_count as $v):
                    ?>
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" data-id="<?=$v['id']?>"  id="List<?=$v['id']?>" value="<?=htmlentities($v['title'])?>">
                      <label class="pull-left Text" for="List<?=$v['id']?>">
                        <?=$v['title']?> <span><?=$v['tour_counted']?></span>
                      </label> 
                    </div> 
                    <?php endforeach; ?>
                </div>
            </div>
          </div>
		  
		  
		      <div class="col-sm-4 padding_0 ResultsColDiv text-right">
            <div class="SearchResultText"><?=l("searchresult")?>: <span id="g-main-serach-result"><?=(isset($items[0]["counted"])) ? $items[0]["counted"] : 0?></span></div>
          </div>
		  

          <div class="col-sm-3" style="display:none;">
            <div class="btn-group SearchFilterItem"> 
                <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
                  <span><?=l("searchbyprice")?></span>
                  <label class="Name2 LocationName" for="List8" id="AmountLabelID"><label>0</label><i>A</i></label>
                </div>
                <div class="dropdown-menu PriceBox">
                    <div class=""> 
                        <div class="PriceSlider"> 
							<span><?=l("pricefrom")?></span>
							<div id="slider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
								<div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="width: 0%;"></div>
								<a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;">
									<label>0</label>
									<div class="ui-slider-label-inner"></div>
								</a>
							</div>
							<input type="hidden" id="amount" class="form-control" value="0">
							<p class="price lead"></p>
                        </div>
					</div>
                </div>
            </div>
          </div>
		  
        </div>
      </div>





      <div class="FiltItemsDiv">
        <div class="row">
          <div class="col-sm-12 itemsListBox"></div>          
        </div>  
      </div>



      <div class="ToursListDiv">
        <div class="ToursList">
          <div class="row tourCatalogList">
            <!-- LOADS TOURS VIA AJAX REQUAST -->
          </div>
          <input type="hidden" name="current_page" class="current_page" id="current_page" value="<?=(isset($_GET['page']) && $_GET['page']>0) ? $_GET['page'] : 1?>" />
          <div style="clear:both"></div>
          <button class="load-more" style="visibility: hidden;">Load More</button>
        </div>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  $(document).ready(function(){
    $("#slider").slider({
        range: "min",
        animate: true,
        value: '<?=(isset($items[0]["minPrice"])) ? (int)$items[0]["minPrice"] : 0?>',
        min: '0',
        max: '<?=(isset($items[0]["maxPrice"])) ? (int)$items[0]["maxPrice"] : 0?>',
        step: 10,
        slide: function (event, ui) {
            update(1, ui.value); //changed
        },
        change: function(event, ui) { 
          changeUrl();
        }
    });

    $("#amount").val(0);
    $("#AmountLabelID label").text(0);
    update();
    <?php 
    $javascriptToDo = "";
    if(isset($_GET['cat']) && !empty($_GET['cat'])){
      $ex = explode(",", $_GET['cat']); 
      for($i=0;$i<count($ex);$i++){
         $javascriptToDo .= '$("#Cat'.$ex[$i].'").trigger("click"); ';
      }
    }

    if(isset($_GET['reg']) && !empty($_GET['reg'])){
      $ex = explode(",", $_GET['reg']); 
      for($i=0;$i<count($ex);$i++){
        $javascriptToDo .= '$("#List'.$ex[$i].'").trigger("click"); ';
      }
    }

    if(isset($_GET['pri']) && !empty($_GET['pri']) && is_numeric($_GET['pri'])){
      $javascriptToDo .= '$("#slider").slider("value", '.(int)$_GET['pri'].'); ';
      $javascriptToDo .= '$("#slider label").text('.(int)$_GET['pri'].');';
      $javascriptToDo .= '$("#AmountLabelID label").text('.(int)$_GET['pri'].');';
    }
    echo $javascriptToDo;
    ?>
    setTimeout(function(){
      changeUrl();
    }, 500);
  });

$(document).on("change", "#mobile-categories, #mobile-regions", function(){
  changeUrlMobile();
});  

function update(slider, val) {
  var $amount = slider == 1 ? val : $("#amount").val();

  $("#amount").val($amount);
  $("#AmountLabelID label").text($amount);
  $('#slider a').html('<label>' + $amount + '</label><div class="ui-slider-label-inner"></div>');
}



var scroll = true;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
        if(scroll){
            scroll = false;
            var val = $("#slider").slider("value");
            var input_lang = $("#input_lang").val();
            var current_page = $("#current_page").val();
            current_page++;
            $("#current_page").val(current_page);
            var CSRF_token = $('meta[name=CSRF_token]').attr("value");
            var cats = new Array();
            var regs = new Array();
            
            $(".CategoriesDropDown .Item").each(function(){
                if($(".TripCheckbox:checked", this).length){
                    cats.push($(".TripCheckbox", this).attr("data-id"));
                }
            });

            $(".RegiosSearchDropDown .Item").each(function(){
                if($(".TripCheckbox:checked", this).length){
                    regs.push($(".TripCheckbox", this).attr("data-id"));
                }
            });

            $.ajax({
                type: "POST",
                url: Config.website+input_lang+"/?ajax=true",
                data: { 
                    type:"loadmorecatalog", 
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
                    console.log(obj.Error.Text);
                }else{
                    $(".ToursList .tourCatalogList").append(obj.Success.Html);
                }
                scroll = true;
            });
        }
    }
});
</script>