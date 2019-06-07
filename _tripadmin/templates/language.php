<?php defined('DIR') OR exit; ?>
<?php
	foreach(c('languages.all') as $language):
		$active = ((l() == $language) ? null : '_r');
		$color = ((l() == $language) ? 'color:#fff;' : 'color:#999;' );
		$cursor = ((l() == $language) ? null : 'cursor:pointer;' );

		$route = Storage::instance()->route;
		$params = generate_params();
?>
<?php if(l() != $language) { ?>
		<li><a style="<?php echo $color;?>" href="<?php echo ($route[1] == 'edit') ? "javascript:nextlang('".$language."')" : ahref(array($route[0], 'show', $route[2]), $params, $language); ?>"><?php echo l_long($language); ?></a></li>
<?php } else { ?>
		<li style="<?php echo $color;?>"><?php echo l_long($language); ?></li>
<?php } ?>
<?php
	endforeach;
?>