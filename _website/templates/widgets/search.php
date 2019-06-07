		  			<!-- // widget // -->
		  				<div class="blog-widget search-widget">
		  					<h2>ძებნა</h2>
		  					<form action="<?php echo href(31);?>" id="srchw"><input type="text" name="q" id="qw" value="" placeholder="საძიებო სიტყვა" onkeyup="searchw(event);"></form>
		  				</div>
		  				<script>
		  					function searchw(e) {
							    if (e.keyCode == 13) {
							        $("#srchw").submit();
							        // var tb = document.getElementById("qw");
							        return false;
							    }
							}
		  				</script>
		  			<!-- \\ widget \\ -->
