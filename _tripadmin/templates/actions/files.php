<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/table.png" width="16" height="16" alt="" /></div>
			<div class="name"><?php echo $pagetitle." - ".$title;?></div>
		</div>

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
                	<a href="<?php echo ahref(array('sitemap', 'edit', $route[1]));?>" id="b1" class="button br"><?php echo a("general");?></a>
                	<a href="<?php echo ahref(array('sitemap', 'edit', $route[1]), array('tabstop' => 'content'));?>" id="b2" class="button br"><?php echo a("content");?></a>
                	<a href="javascript:;" id="b3" class="selbutton br"><?php echo a("files");?></a>
				</div>
				<div id="news">
					<form id="dataform" name="dataform" method="post" action="<?php echo ahref(array($route[0], 'add', $route[1]));?>">
                    <input type="hidden" name="file_form_perform" value="1" />
					<input type="hidden" name="tabstop" id="tabstop" value="main" />
                    <div class="list2 fix">
                        <div class="name"><?php echo a("title");?> <span class="star">*</span></div>
                        <input type="text" name="title" id="filetitle" value="" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name"><?php echo a("addfiles");?>: <span class="star">*</span></div>
                        <input type="text" id="file" name="file" value="" class="inp" style="width:500px;" />
                        <a href="javascript:;" class="popup button br" data-browse="file"><?php echo a('browse') ?></a>
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
						<div class="name-title" style="width:600px;"><?php echo a("name").', '.a("URL");?></div>
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
        $arrow_up = $is_first ? '<img src="_tripadmin/img/none.png" width="10" height="7" />' : '<a href="javascript:pos(\'up\',\''.$file['id'].'\')"><img src="_tripadmin/img/buttons/icon_arrow_up.png" class="star" title="' .  a('tt.moveup') . '" width="10" height="7" /></a>';
        $arrow_down = $is_last ? '<img src="_tripadmin/img/none.png" width="10" height="7" />' : '<a href="javascript:pos(\'down\',\''.$file['id'].'\')"><img src="_tripadmin/img/buttons/icon_arrow_down.png" class="star" title="' .  a('tt.movedn') . '" width="10" height="7" /></a>';
		$arrows = $arrow_up . $arrow_down;
        $count++;
		if($class == 'list2') $class = 'list'; else $class = 'list2';
		$ext = strtolower(substr(strrchr($file['file'], '.'), 1));
?>
					<div class="<?php echo $class;?> fix" id="div<?php echo $file["id"];?>">
						<ul class="action fix">
                        	<a href="<?php echo href($route[1]) ?>" target="_blank"><img src="_tripadmin/img/buttons/icon_preview.png" class="star" title="<?php echo a('ql.preview');?>" /></a>
                            <a href="javascript:del(<?php echo $file['id'];?>, '<?php echo $file['title'];?>');"><img src="_tripadmin/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
						</ul>
						<div class="icon"><img src="_tripadmin/img/icons/<?php echo $ext;?>.gif" /></div>
						<div class="icon"><?php echo $arrows;?></div>
						<div class="name" style="white-space:nowrap;width:680px;"><?php echo $file['title'].'<br />'.$file['file'] ?></div>
						<div class="date">&nbsp;</div>
						<div class="id"><?php echo $file['id']; ?></div>
					</div>
<?php
	endforeach;
?>
                </div>
				<div id="bottom" class="fix">
					<a href="<?php echo ahref(array('sitemap', 'edit', $route[1]));?>" class="button br"><?php echo a("back");?></a>
                </div>
			</div>
		</div>
<script language="javascript" type="text/javascript">
$(document).on('click', function(e){
    target = $(e.target);
    if (target.hasClass('popup')) {
        id = target.data('browse');
        $.fancybox({
            width    : 985,
            height   : 600,
            type     : 'iframe',
            href     : '<?php echo JAVASCRIPT ?>/tinymce/filemanager/dialog.php?field_id='+id,
            autoSize : false
        });
        e.preventDefault();
    }
});
function save() {
	var validate = 0;
	var msg = "";
	if($("#filetitle").val()=='') {
		msg = "<?php echo a('error.title');?>";
		validate = 0;
	} else if ($("#file").val()=='') {
		msg = "<?php echo a('error.file');?>";
		validate = 0;
	} else {
		validate = 1;
	}
	if(validate == 1) {
		this.dataform.submit();
	} else {
		alert(msg);
	}
};
function pos(where,id) {
	var pos = $(document).scrollTop();
	window.location = "<?php echo ahref(array($route[0], 'move'));?>?where="+where+"&file="+id+"&id=<?php echo $route[1] ?>&pos="+pos;
}
function del(id, title) {
	if (confirm("<?php echo a('deletequestion'); ?>" + title + "?")) {
		$.post("<?php echo ahref(array($route[0], 'delete')); ?>?file=" + id, function(){
			$("#div" + id).innerHTML = "";
			$("#div" + id).hide();
		});
	}
}
<?php if (isset($_GET["pos"])): ?>
    $(function(){
        $("html, body").scrollTop(<?php echo intval($_GET["pos"]) ?>);
    });
<?php endif ?>
</script>
