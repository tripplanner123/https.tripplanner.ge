<?php defined('DIR') OR exit;?>

<div class="InsidePagesHeader">
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_1.jpg');"></div>
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_2.jpg');"></div>
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_3.jpg');"></div>
  <div class="Item" style="background:url('<?=WEBSITE?>/img/trip_4.jpg');"></div>
</div>

<div class="TripListPageDiv">
  <div class="TripListInsidePage">
    <div class="container">
      
      <h3 class="PageTitle InsideTitle"><label>Plan Your Trip</label></h3>

      <div class="row row0">
        <div class="col s12">
          <div class="Breadcrumb"> 
            <a href="#" class="Nolink">Home</a>
              <span>&gt;</span>
            <a href="#">Ongoing Tour</a>
          </div>
        </div>
      </div>

      <div class="FiltersDiv">
        <div class="row row0">
          <div class="AllToursButton">All Tours <div>150</div></div>
          <div class="col-sm-3">
            <div class="btn-group SearchFilterItem"> 
                <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
                  <span class="Name1">Search By Categories</span>
                  <label class="Name2 CatagoryName"><text>Museums</text></label>
                </div>
                <div class="dropdown-menu CategoriesDropDown"> 
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" value="Museums" name="layout" id="Cat1" checked="">
                  <label class="pull-left Text" for="Cat1">
                    <div class="Info">
                      <div class="Image Museums"></div>
                      <div class="Title">Museums</div>
                      <div class="Count">15</div>
                    </div>
                  </label> 
                    </div>
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" value="Natural Sights" name="layout" id="Cat2">
                  <label class="pull-left Text" for="Cat2">
                    <div class="Info">
                      <div class="Image Natural"></div>
                      <div class="Title">Museums</div>
                      <div class="Count">15</div>
                    </div>
                  </label> 
                    </div> 
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" value="Cultural Sights" name="layout" id="Cat3">
                  <label class="pull-left Text" for="Cat3">
                    <div class="Info">
                      <div class="Image Cultural"></div>
                      <div class="Title">Museums</div>
                      <div class="Count">15</div>
                    </div>
                  </label> 
                    </div>
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" value="Wine Tours" name="layout" id="Cat4">
                  <label class="pull-left Text" for="Cat4">
                    <div class="Info">
                      <div class="Image WineTours"></div>
                      <div class="Title">Museums</div>
                      <div class="Count">15</div>
                    </div>
                  </label> 
                    </div>
                </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="btn-group SearchFilterItem"> 
                <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
                  <span class="Name1">Search By Location</span>
                  <label class="Name2 LocationName InpueValue2"><text>Tbilisi</text></label>
                </div>
                <div class="dropdown-menu LocationDropDown LocationDropDown2"> 
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" id="List1" value="Imereti">
                  <label class="pull-left Text" for="List1">
                    Imereti <span>15</span>
                  </label> 
                    </div> 
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" id="List2" value="Adjara">
                  <label class="pull-left Text" for="List2">
                    Adjara
                  </label> 
                    </div>
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" id="List3" value="Abkhazia">
                  <label class="pull-left Text" for="List3">
                    Abkhazia <span>15</span>
                  </label> 
                    </div>
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" id="List4" value="Samegrelo">
                  <label class="pull-left Text" for="List4">
                    Samegrelo <span>5</span>
                  </label> 
                    </div>
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" id="List5" value="Svaneti">
                  <label class="pull-left Text" for="List5">
                    Svaneti
                  </label> 
                    </div>
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" id="List6" value="Tbilisi" checked="">
                  <label class="pull-left Text" for="List6">
                    Tbilisi
                  </label> 
                    </div>
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" id="List7" value="Guria">
                  <label class="pull-left Text" for="List7">
                    Guria
                  </label> 
                    </div>
                    <div class="Item">
                      <input class="TripCheckbox" type="checkbox" id="List8" value="yazbegi">
                  <label class="pull-left Text" for="List8">
                    yazbegi
                  </label> 
                    </div>
                </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="btn-group SearchFilterItem"> 
                <div class="dropdown-toggle TripTogglebutton" data-toggle="dropdown">
                  <span>Search By Price</span>
                  <label class="Name2 LocationName" for="List8" id="AmountLabelID"><label>0</label><i>A</i></label>
                </div>
                <div class="dropdown-menu PriceBox">
                    <div class=""> 
                        <div class="PriceSlider"> 
                          <span>Price Range</span>
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
          <div class="col-sm-8">
            <div class="Item">Museums <div class="Remove"><i class="fa fa-times"></i></div></div>
            <div class="Item">Wine Tours <div class="Remove"><i class="fa fa-times"></i></div></div>
            <div class="Item">Tbilisi <div class="Remove"><i class="fa fa-times"></i></div></div>
            <div class="Item">2017-09-22 <div class="Remove"><i class="fa fa-times"></i></div></div>
            <div class="Item">500 <div class="Remove"><i class="fa fa-times"></i></div></div>
          </div>
          <div class="col-sm-4 text-right">
            <div class="SearchResultText">Search Results: <span><?=$items[0]["counted"]?></span></div>
          </div>
        </div>  
      </div>

      <div class="ToursListDiv">
        <div class="ToursList">
          <div class="row">
            <?php 
            foreach ($items as $item): 
              $link = href($id,array(), l(), $item['id']);
            ?>
            <div class="col-sm-3">
                <div class="Item">
                  <div class="TopInfo" onclick="location.href='<?=$link?>'">
                    <div class="Background" style="background:url('<?=$item['image1']?>');"></div>
                    <div class="UserCount"><span>7</span></div>
                  </div>
                  <div class="BottomInfo" onclick="location.href='<?=$link?>'">
                    <div class="Title"><?=g_cut($item['title'], 40)?></div>
                    <div class="Day"><?=$item['day_count']?> day</div>
                    <div class="Price">Package Price: <span><?=$item['price']?> <i>A</i></span></div>             
                  </div>
                  <div class="Buttons">
                    <a href="javascript:void(0)"><span class="CartIcon"></span> Add To Cart</a>
                    <a href="javascript:void(0)"><span class="WishListIcon"></span> Add To WishList</a>
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

<script type="text/javascript">
  $(document).ready(function(){
    $("#slider").slider({
        range: "min",
        animate: true,
        value: 1,
        min: '<?=(isset($items[0]["minPrice"])) ? (int)$items[0]["minPrice"] : 0?>',
        max: '<?=(isset($items[0]["maxPrice"])) ? (int)$items[0]["maxPrice"] : 0?>',
        step: 10,
        slide: function (event, ui) {
            update(1, ui.value); //changed
        }
    });
  });
</script>

<!-- <div class="main-cont">
  <div class="body-wrapper">
    <div class="page-head">
    	 <div class="wrapper-padding">
		      <div class="page-title"><?php echo $title;?></div>
		      <div class="clear"></div>
	     </div>
    </div>
    <div class="columns">
   	 <div class="content-wrapper columns">
        <div class="columns-block">
            <div class="columns-row shop">
<?php
  	foreach ($items as $item):
      	$link = href($id,array(), l(), $item['id']);
		$link = $item['image1'];
?>
				<div class="column mm-3">
					<a class="offer-slider-img popup-img" href="<?php echo $link; ?>">
						<img alt="" src="<?php echo $item['image1'];?>">
						<span class="offer-slider-overlay" style="display: none;">
							<span class="offer-slider-btn" style="top: -200px;">დეტალურად</span>
						</span>
					</a>
					<div class="offer-slider-txt">
						<div class="offer-slider-link"><a class="popup-img" href="<?php echo $link; ?>"><?php echo $item['title'];?></a></div>
						<div class="flat-adv-c">
							<?php echo $item['description'];?>
						</div>	
						<div class="shop-price">
							<span class="lab">
								ფასი:
							</span>
							<span class="val">
								<?php echo $item['price'];?> ლ
							</span>
						</div>				
						<div class="clear"></div>
					</div>
				</div>
<?php endforeach; ?>
            </div>
            <div class="clear"></div>
    	</div>
<?php
	if (isset($item_count) AND $item_count > count($items)):
?>
    	<div class="wrapper-padding ip-full-width">
          	<div class="padding">
	            <div class="pagination">
<?php
        if ($page_num > 1):
?>
                                <a href="<?php echo $link . '?page=1'; ?>">&laquo;&laquo;</a>
                                <a href="<?php echo $link . '?page=' . ($page_num - 1); ?>">&laquo;</a>
<?php
        endif;
        $per_side = 5;
        $index_start = ($page_num - $per_side) <= 0 ? 1 : $page_num - $per_side;
        $index_finish = ($page_num + $per_side) >= $page_max ? $page_max : $page_num + $per_side;
        if (($page_num - $per_side) > 1)
            echo '<a href="javascript:">...</a>';
        for ($idx = $index_start; $idx <= $index_finish; $idx++):
?>
                                <a href="<?php echo $link . '?page=' . $idx; ?>"><?php echo $idx ?></a>
<?php
        endfor;
        if (($page_num + $per_side) < $page_max)
            echo '<li class="pages"><a href="javascript:">...</a></li>';
        if ($page_num < $index_finish):
?>
                                <a href="<?php echo $link . '?page=' . ($page_num + 1); ?>">&raquo;</a>
                                <a href="<?php echo $link . '?page=' . $page_max; ?>">&raquo;&raquo;</a>
<?php
        endif;
?>
                         </div>
	              <div class="clear"></div>           
         	 	</div>
	        	<br class="clear" />
	    		<div class="clear"></div>
	    	</div>
<?php
    endif;
?>
    	</div>
  	</div>
  </div>
<?php require("_website/templates/widgets/popular.php");?>
    
</div> -->
