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

      <h3 class="PageTitle InsideTitle"><label><?=menu_title(194)?></label></h3>

      <div class="row row0">
        <div class="col s12">
          <div class="Breadcrumb"> 
            <a href="#" class="Nolink"><?=menu_title(1)?></a>
              <span>&gt;</span>
            <a href="#"><?=menu_title(194)?></a>
          </div>
        </div>
      </div>


      <div class="g-collapse">
        <div class="accordion" id="accordionExample">
          <?php 
          $x = 1;
          foreach($lists as $list): ?>
          <div class="card">
            <div class="card-header" id="heading<?=$list['id']?>">
              <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$list['id']?>" aria-expanded="true" aria-controls="collapse<?=$list['id']?>">
                <?=$x?>. <?=strip_tags($list['title'])?>
                </button>
              </h5>
            </div>

            <div id="collapse<?=$list['id']?>" class="collapse" aria-labelledby="heading<?=$list['id']?>" data-parent="#accordionExample">
              <div class="card-body">
              <?=strip_tags($list['description'], "<p><br><a><strong>")?>
              </div>
            </div>
          </div>
          <?php $x++; endforeach; ?>


        </div>
      </div>

      

    </div>
  </div>
</div>