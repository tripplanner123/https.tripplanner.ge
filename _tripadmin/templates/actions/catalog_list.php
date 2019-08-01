<?php defined('DIR') OR exit;
	$params = get();

	$regions_list = db_fetch_all("SELECT `id`, `title` FROM `pages` WHERE `menuid` = 27 AND `visibility` = 1 AND `deleted` = 0 AND `language`='".l()."'");
    $categories_list = db_fetch_all("SELECT `id`, `title` FROM `pages` WHERE `menuid` = 34 AND `visibility` = 1 AND `deleted` = 0 AND `language`='".l()."'");
?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/edit.png" width="16" height="16" alt="" /></div>
			<div class="name"><?php echo a("mt.catalog");?>: <?php echo $title;?></div>
		</div>

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<input type="text" class="inp" id="srch" name="srch" style="margin-top:0px;" value="<?php echo get('srch'); ?>" />
					
					<select name="categories_list" id="categories_list" class="inp-small" style="margin: 0 5px; float: left;">
						<option value="">აირჩიეთ კატეგორია</option>
						<?php foreach($categories_list as $cat): ?>
						<option value="<?=(int)$cat['id']?>" <?=(isset($_GET["cat"]) && $_GET["cat"]==$cat["id"]) ? 'selected' : ''?>><?=$cat['title']?></option>
						<?php endforeach; ?>
					</select>

					<select name="regions_list" id="regions_list" class="inp-small" style="margin: 0 5px; float: left;">
						<option>აირჩიეთ რეგიონი</option>
						<?php foreach($regions_list as $reg): ?>
						<option value="<?=(int)$reg['id']?>" <?=(isset($_GET["reg"]) && $_GET["reg"]==$reg["id"]) ? 'selected' : ''?>><?=$reg['title']?></option>
						<?php endforeach; ?>
					</select>

					<a href="javascript:srch();" class="button br"><?php echo a('search');?></a>
					<a href="<?php echo ahref(array($route[0], 'show', $route[2]));?>" class="button br"><?php echo a('reset');?></a>
					
					<a href="<?php echo ahref(array($route[0], 'add', $route[2]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addcatalogitem");?></a>
				</div>
				<div id="info">
					<div class="list-top">
						<div class="vis"><?php echo a("vis");?>.</div>
						<div class="name-title"><span style="padding-left:45px;"><?php echo a("title");?></span></div>
						<!-- <div class="name">კატეგორია</div> -->
						<div class="act fix"><?php echo a("actions");?></div>
						<div class="pid">ID</div>
						<?php if(isset($route[2]) && $route[2]==24): // if ongoing catalog list ?>
						<div class="ptype">visiable on</div> 
						<?php endif; ?>

					</div>
					<?php
					$class = 'list';
				    $total = $count;
				    $cnt = 1;
					if($total > 0) :
						foreach($catalogs as $catalog) :
							$is_first = ($cnt == 1);
							$is_last = ($cnt >= $total);
							$arrow_up = $is_first ? '<img src="_tripadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="javascript:pos(\'up\',\''.$catalog['id'].'\')"><img src="_tripadmin/img/buttons/icon_arrow_up.png" alt="Move Up" title="Move Up" width="9" height="9" /></a>';
							$arrow_down = $is_last ? '<img src="_tripadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="javascript:pos(\'down\',\''.$catalog['id'].'\')"><img src="_tripadmin/img/buttons/icon_arrow_down.png" alt="Move Down" title="Move Down" width="9" height="9" /></a>';
							$arrows = $arrow_up . $arrow_down;
							$cnt++;
							if($class == 'list2') $class = 'list'; else $class = 'list2';
							$ch = ($catalog["visibility"]==1) ? '' : 'un';
					?>
						<div class="<?php echo $class;?> fix" id="div<?php echo $catalog["id"] ?>">
							<div class="check">
								<a href="javascript:chclick('<?php echo $catalog['id']; ?>');"><img src="_tripadmin/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $catalog['id'];?>" style="width:9px;height:9px;" /></a>
	                            <input type="hidden" name="vis_<?php echo $catalog['id'];?>" id="vis_<?php echo $catalog['id'];?>" value="<?php echo $catalog['visibility'];?>" />
	                        </div>
							<div class="icon"><?php echo $arrows;?></div>
							<div class="catname">
								<strong><a href="<?php echo ahref(array($route[0], 'edit', $catalog['id']));?>"><?php echo $catalog["title"];?></a></strong>
	                            <br />
								<a href="<?php echo href($pageid, array(), l(), $catalog["id"]) ?>" class="left" target="_blank">
		                        	<span class="star" style="font-size:10px; color:#999" title="<?php echo href($pageid, array(), l(), $catalog["id"]) ?>">
										<?php echo mb_substr(href($pageid, array(), l(), $catalog["id"]), 0,84,'UTF-8') . ((mb_strlen(href($pageid, array(), l(), $catalog["id"]),'UTF-8')>84) ? '...' : '');?>
		                    		</span>
		                        </a>
	                        </div>
							<!-- <div class="catfield"></div> -->

							<div class="action fix">
								<a href="<?php echo ahref(array($route[0], 'edit', $catalog['id']));?>" title="<?php echo a('ql.edit');?>"><img src="_tripadmin/img/buttons/icon_edit.png" /></a>
								<a href="javascript:del(<?php echo $catalog['id'];?>, '<?php echo $catalog['title'];?>');" title="<?php echo a('ql.delete');?>"><img src="_tripadmin/img/buttons/icon_delete.png" /></a>
							</div>
							<div class="id"><?php echo $catalog["id"];?></div>
							<?php if(isset($route[2]) && $route[2]==24): // if ongoing catalog list ?>
							<div class="date">
								<?php echo ($catalog["show_tripplanner"]==2) ? 'trip ' : '';?>
								<?php echo ($catalog["show_beetrip"]==2) ? ' beetrip' : '';?>
							</div>
							<?php endif; ?>
						</div>
					<?php
						endforeach;
					endif;
					?>
				</div>
				
				<div id="bottom" class="fix">
					<?php
						$curpage = ceil((get("start", 0) + 1) / 50);
						$lastpage = ceil(($count) / 50);
						$j = ($curpage > 1) ? $curpage - 1 : 0; 
						$k = ($curpage < $lastpage) ? $curpage + 1 : $lastpage;
					?>
					<ul id="page" class="fix left" style="width:720px; float: left;">
						<li><a href="<?php echo ahref(array($route[0], 'show', $route[2]), $params) ?>"><img src="_tripadmin/img/prev2.png" width="5" height="5" alt=""  class="arrow" /></a></li>
						<li><a href="<?php echo ahref(array($route[0], 'show', $route[2]), $params) ?>"><img src="_tripadmin/img/prev.png" width="5" height="5" alt=""  class="arrow" /></a></li>
						<?php
							for($i = 1; $i<=$lastpage; $i++) {
								$start = ($i-1)*50;
								$params["start"] = $start;
						?>
						<li><?php echo ($i == $curpage) ? '<span style="color:#2e84d7; font-weight:bold;">' : '<a href="'.ahref(array($route[0], 'show', $route[2]), $params).'">';?><?php echo $i;?><?php echo ($i == $curpage) ? '</span>' : '</a>';?></li>
						<?php
							}
						?>
						<li><a href="<?php echo ahref(array($route[0], 'show', $route[2]), $params) ?>"><img src="_tripadmin/img/next.png" width="5" height="5" alt="" class="arrow" /></a></li>
						<li><a href="<?php echo ahref(array($route[0], 'show', $route[2]), $params) ?>"><img src="_tripadmin/img/next2.png" width="5" height="5" alt="" class="arrow" /></a></li>
					</ul>
					<a href="<?php echo ahref(array($route[0], 'add', $route[2])) ;?>" class="button br" id="addcategory" style="float: right"><?php echo a("addcatalogitem");?></a>
				</div>
			</div>
		</div>



<script language="javascript">
function chclick(id) {
	var active = ($('#vis_'+id).val()==0) ? 1 : 0;
	$.post("<?php echo ahref(array($route[0], 'visibility'), array('ajax' => 1));?>&visibility=" + active + "&id=" + id, function(data) {
		if(active==1)
	        $('#img_'+id).attr("src","_tripadmin/img/buttons/icon_visible.png");
		else
	        $('#img_'+id).attr("src","_tripadmin/img/buttons/icon_unvisible.png");
		$('#vis_'+id).val(active);
	});
}
function pos(where,id) {
	var pos = $(document).scrollTop();
	window.location = "<?php echo ahref(array($route[0], 'move'));?>?where="+where+"&menu=<?php echo $route[2] ?>&id="+id+"&pos="+pos;
}
function chccat(idx, cat) {
	window.location="<?php echo ahref(array($route[0], 'changecatalog'));?>?idx=" + idx + "&cat=" + cat + "&menu=<?php echo $route[2];?>";
}
function del(id, title) {
	if (confirm("<?php echo a('deletequestion'); ?>" + title + "?")) {
		$.post("<?php echo ahref(array($route[0], 'delete'));?>?menu=<?php echo $route[2] ?>&id=" + id, function(){
			$("#div" + id).innerHTML = "";
			$("#div" + id).hide();
		});
	}
}
function srch() {
	var cat = $("#categories_list").val();
	var reg = $("#regions_list").val();
	window.location="<?php echo ahref(array($route[0], 'show', $route[2]));?>?srch=" + $("#srch").val()+"&cat="+cat+"&reg="+reg;
}
<?php if (isset($_GET["pos"])): ?>
    $(function(){
        $("html, body").scrollTop(<?php echo intval($_GET["pos"]) ?>);
    });
<?php endif ?>

$(".list").mouseover(function(){
    	$(this).css('background', '#ededed');
    }).mouseout(function(){
    	$(this).css('background', '#f8f8f8');
    });
$(".list2").mouseover(function(){
    	$(this).css('background', '#ededed');
    }).mouseout(function(){
    	$(this).css('background', '#ffffff');
    });
</script>