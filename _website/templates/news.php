<?php defined('DIR') OR exit; ?>
<div class="BlogPageSlider">
	<div class="Item" style="background:url('https://tripplanner.ge/image.php?f=<?=$image1?>&w=1400&h=550');">
		
		<div class="Info">
			<div class="container">
				<div class="Title"><?=l("bestplacegeorgia")?></div>
				<div class="Text"><?=l("blogsupertitle")?></div>
				<!-- <a href="#" class="GreenCircleButton BlogHeaderButton">More</a> -->
			</div>
		</div>
	</div>
</div>


<div class="BlogPageDiv">
	<div class="BlogListDiv">
		<div class="container">
			<h3 class="PageTitle">
				<label><?=$title?></label>
			</h3>
			<div class="BlogTopInfo">
				<div class="row">
					<div class="col-sm-9">
						
						

						<div class="BlogTags">
							<li class="<?=(!isset($_GET['h'])) ? 'active' : ''?>"><a href="/<?=l()?>/blog"># <?=l("all")?></a></li>
							<?php
							foreach (g_news_hashes() as $v):
							?>
								<li class="<?=(isset($_GET['h']) && $_GET['h']==$v) ? 'active' : ''?>"><a href="/<?=l()?>/blog?h=<?=$v?>"># <?=$v?></a></li>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="SearchInputs">
							<form action="/<?=l()?>/blog" method="get">
								<input type="hidden" name="CSRF_token" value="<?=@$_SESSION["CSRF_token"]?>" />	
							<input type="text" name="s" placeholder="<?=l("search")?>" autocomplete="off" value="<?=(isset($_GET['s']) && !empty($_GET['s'])) ? htmlentities($_GET['s']) : ''?>" />
							<button type="submit"><i class="fa fa-search"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>	
			<div class="BlogList">
				<div class="row">
					<?php 
					echo news(10);
					?>					
				</div>
			</div>	
		</div>
	</div>
</div>

<script type="text/javascript">
	 $('.BlogPageSlider').slick({
    		dots: false,
    		infinite: false,
    		arrows: false,
    		speed: 800,
    		slidesToShow: 1,
    		slidesToScroll: 1,
    		autoplay: false,
    		autoplaySpeed: 2000
    	});
</script>