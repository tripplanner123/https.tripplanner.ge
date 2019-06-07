		  			<!-- // widget // -->
<?php
	$art = db_fetch_all("select pages.* from pages inner join menus on pages.menuid = menus.id and menus.language='".l()."' and menus.type='articles' where pages.language='".l()."' order by postdate desc limit 0,2");
?>
		  				<div class="blog-widgets-b">
		  					<div class="title">
		  						<h2>ახალი სტატიები</h2>
		  					</div>
		  					<div class="blog-widgets">
<?php foreach($art as $a) : ?>
				  				<div class="blog-widget text-widget">
				  					<h3><a href="<?php echo href($a["id"]);?>"><?php echo $a["title"];?></a></h3>
				  					<b><?php echo convert_date($a["postdate"]);?></b>
				  					<?php echo $a["description"];?>
				  				</div>
<?php endforeach; ?>
			  				</div>
		  				</div>
		  			<!-- \\ widget \\ -->
