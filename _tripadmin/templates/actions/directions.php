<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/table.png" width="16" height="16" alt="" /></div>
                <?php
                	$pagetitle = db_fetch("SELECT title FROM pages WHERE idx=".get("idx")."");
                ?>
			<div class="name"><?php echo $pagetitle["title"]." - ".$title;?></div>
		</div>

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
                	<a href="<?php echo ahref('sitemap', 'edit', array('menu' => $menu, 'id' => $id, 'idx' => $idx));?>" id="b1" class="button br"><?php echo a("general");?></a>
                	<a href="<?php echo ahref('sitemap', 'edit', array('menu' => $menu, 'id' => $id, 'idx' => $idx));?>&tabstop=content" id="b2" class="button br"><?php echo a("content");?></a>
                	<a href="<?php echo ahref('files', '', array('menu' => $menu, 'id' => $id, 'idx' => $idx));?>&tabstop=content" id="b3" class="button br">ფაილები</a>
                	<a href="javascript:;" id="b4" class="selbutton br">მიმართულებები</a>
				</div>
				<div id="news">
					<form id="dataform" name="dataform" method="post" action="<?php echo ahref($action, 'add', array('menu'=> $menu, 'id' => $id, 'idx'=> $idx));?>">
                    <input type="hidden" name="file_form_perform" value="1" />
					<input type="hidden" name="tabstop" id="tabstop" value="main" />
                    <div class="list2 fix">
                        <div class="name"><?php echo a("title");?> <span class="star">*</span></div>
                        <input type="text" name="title" value="<?php echo ($subaction=='edit') ? $edit["title"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list fix">
						<a href="javascript:save();" class="button br" style="float: right"><?php echo a('add');?></a>
					</div>
					</form>
				</div>
                <div id="info">
					<div class="list-top">
						<div class="action fix"><?php echo a("actions");?></div>
						<div class="icon">&nbsp;</div>
						<div class="name-title" style="width:600px;"><?php echo a("name");?></div>
						<div class="date">&nbsp;</div>
						<div class="id">ID</div>
					</div>
<?php
	$class = 'list';
    $total = count($files);
    $count = 1;
	foreach($files as $file) :
        $is_first = ($count == 1);
        $is_last = ($count >= $total);
        $arrow_up = $is_first ? '<img src="_tripadmin/img/none.png" width="10" height="7" />' : '<a href="' . ahref('files', 'move', array('where' => 'up', 'menu' => $menu, 'id' => $id, 'idx'=> $idx, 'pos'=> $file['id'])) . '"><img src="_tripadmin/img/buttons/icon_arrow_up.png" class="star" title="' .  a('tt.moveup') . '" width="10" height="7" /></a>';
        $arrow_down = $is_last ? '<img src="_tripadmin/img/none.png" width="10" height="7" />' : '<a href="' . ahref('files', 'move', array('where' => 'down', 'menu' => $menu, 'id' => $id, 'idx'=> $idx, 'pos'=> $file['id'])) . '"><img src="_tripadmin/img/buttons/icon_arrow_down.png" class="star" title="' .  a('tt.movedn') . '" width="10" height="7" /></a>';
		$arrows = $arrow_up . $arrow_down;
        $count++;
		if($class == 'list2') $class = 'list'; else $class = 'list2';
		$ext = strtolower(substr(strrchr($file['path'], '.'), 1));
?>
					<div class="<?php echo $class;?> fix" id="div<?php echo $file["id"];?>">
						<ul class="action fix">
                        	<a href="<?php echo href(get('id',1)) ?>" target="_blank"><img src="_tripadmin/img/buttons/icon_preview.png" class="star" title="<?php echo a('ql.preview');?>" /></a>
                            <a href="javascript:del(<?php echo $file['id'];?>, '<?php echo $file['title'];?>');"><img src="_tripadmin/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
						</ul>
						<div class="icon"></div>
						<div class="icon"><?php echo $arrows;?></div>
						<div class="name" style="white-space:nowrap;width:680px;"><?php echo $file['title']; ?>&nbsp;</div>
						<div class="date">&nbsp;</div>
						<div class="id"><?php echo $file['id']; ?></div>
					</div>
<?php
	endforeach;
?>
                </div>
				<div id="bottom" class="fix">
					<a href="<?php echo ahref('sitemap', 'edit', array('menu' => $menu, 'id' => $id, 'idx' => $idx));?>" class="button br"><?php echo a("back");?></a>
                </div>
			</div>
		</div>
<script language="javascript">
function save() {
	var validate = 0;
	var msg = "";
	if($("#title").val()=='' && $("#path").val()=='') {
		msg = "<?php echo a('error.title.file');?>";
		validate = 0;
	} else {
		validate = 1;
	}
	if(validate == 1) {
		this.dataform.submit();
	} else {
		alert(msg);
	}
}
function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) {
		$.post("<?php echo ahref('files', 'delete');?>&id=" + id + "&idx=<?php echo $_GET["idx"];?>", function(){
			$("#div" + id).innerHTML = "";
			$("#div" + id).hide();
			setFooter();
		});
	}
}
</script>
