<?php defined('DIR') OR exit; ?>

<div class="BlogPageSlider SmallHeader slick-initialized slick-slider slick-dotted">
	<div class="slick-list draggable">
		<div class="slick-track" style="opacity: 1; width: 1349px; transform: translate3d(0px, 0px, 0px);">
			<div class="Item slick-slide slick-current slick-active" style="background: url('<?=$image1?>'); width: 1349px;" data-slick-index="0" aria-hidden="false" tabindex="0" role="tabpanel" id="slick-slide00" aria-describedby="slick-slide-control00"></div>
		</div>
	</div>
	<ul class="slick-dots" role="tablist">
		<li class="slick-active" role="presentation">
			<button type="button" role="tab" id="slick-slide-control00" aria-controls="slick-slide00" aria-label="1 of 1" tabindex="0" aria-selected="true">1</button>
		</li>
	</ul>
</div>
<div class="BlogPageDiv">
	<div class="BlogInsidePage"> 
		<div class="container">
			<h1 class="BlogTitle"><?php echo $title ?></h1>
			<!-- <div class="AuthorBy">Author By: <?php echo $author;?></div> -->
			<div class="Date"><?php echo g_convert_date($postdate);?></div>
			<div class="Description">
				<?php echo $content ?>
			</div>
			<div class="BlogTags"> 
				<?php 
				$tags = explode(",", $meta_keys);
				foreach($tags as $tag) :
				?>	
					<li><a href="<?php echo href(86).'?h='.trim($tag," ");?>"><?php echo $tag;?></a></li>
				<?php
				endforeach;
				?>
			</div>
			
		</div>
	</div>

	<!-- <div class="MoreBlogList">
		<div class="container">
			<div class="Title">You might also like...</div>
			<div class="BlogList">
				<div class="row">
					<div class="col-sm-3">
						<div class="Item">
							<div class="TopInfo">
								<div class="Background" style="background:url('img/blog_1.png');"></div> 
								<div class="Date">12.10.2017</div>
							</div>
							<div class="BottomInfo">
								<div class="Title">One Day Tour In Yazbegi</div>  							
								<div class="Text">Tourist zones, where it is possible to do some extreme sports, make the idea</div>
							</div>
							<div class="Buttons">
								<a href="blog_inside.html">More</a> 
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="Item">
							<div class="TopInfo">
								<div class="Background" style="background:url('img/blog_2.png');"></div> 
								<div class="Date">12.10.2017</div>
							</div>
							<div class="BottomInfo">
								<div class="Title">One Day Tour In Yazbegi</div>  							
								<div class="Text">Tourist zones, where it is possible to do some extreme sports, make the idea</div>
							</div>
							<div class="Buttons">
								<a href="blog_inside.html">More</a>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="Item">
							<div class="TopInfo">
								<div class="Background" style="background:url('img/blog_3.png');"></div> 
								<div class="Date">12.10.2017</div>
							</div>
							<div class="BottomInfo">
								<div class="Title">One Day Tour In Yazbegi</div>  							
								<div class="Text">Tourist zones, where it is possible to do some extreme sports, make the idea</div>
							</div>
							<div class="Buttons">
								<a href="blog_inside.html">More</a>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="Item">
							<div class="TopInfo">
								<div class="Background" style="background:url('img/blog_4.png');"></div> 
								<div class="Date">12.10.2017</div>
							</div>
							<div class="BottomInfo">
								<div class="Title">One Day Tour In Yazbegi</div>  							
								<div class="Text">Tourist zones, where it is possible to do some extreme sports, make the idea</div>
							</div>
							<div class="Buttons">
								<a href="blog_inside.html">More</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> -->

</div>
