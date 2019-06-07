<?php
	$videos = db_fetch_all("select * from galleries where link like '%yout%' and language='".l()."' order by position desc limit 0,2");
?>
		  			<!-- // widget // -->
		  				<div class="blog-widgets-b">
		  					<div class="title">
		  						<h2>ახალი ვიდეოები</h2>
		  					</div>
		  					<div class="blog-widgets">
<?php foreach($videos as $v) : ?>
				  				<div class="blog-widget text-widget">
				  					<h3><a href="<?php echo href(22).'?v='.$v["id"];?>"><?php echo $v["title"];?></a></h3>
				  					<b><?php echo convert_date($v["postdate"]);?></b>
				  				</div>
<?php endforeach; ?>
			  				</div>
		  				</div>
		  			<!-- \\ widget \\ -->
