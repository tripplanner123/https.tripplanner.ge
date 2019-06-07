<?php defined('DIR') OR exit; ?>

      <div id="page-header">
        <div class="container">
          <ol class="breadcrumb">
            <?php echo location();?>
          </ol>
          <div id="page-title">
            <h1><?php echo $title ?></h1>
          </div>
        </div>
      </div>
      <div class="section">
        <div class="container">
          <div class="catalog-list row">
          <?php
              foreach ($parents as $item):
                  $link = href($item['id']);
          ?>
            <div class="col-sm-4">
              <div class="catalog">
                <a href="<?php echo $link ?>">
                  <div class="img">
                    <img src="<?php echo $item['image1'] ?>" width="370" height="170" class="img-responsive center-block" alt="">
                  </div>
                  <div class="title">
                    <h2><?php echo $item['title'] ?></h2>
                  </div>
                </a>
              </div>
            </div>
          <?php endforeach ?>
          </div>
        </div>
      </div>

