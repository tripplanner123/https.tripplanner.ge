<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_tripadmin/img/edit.png" width="16" height="16" alt="" /></div>
			<div class="name"><?php echo $pagetitle ?></div>
		</div>

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
				</div>

				<div id="news">
					<div class="list fix">
						<div class="icon"><a href="#"><img src="_tripadmin/img/minus.png" width="16" height="16" alt="" /></a></div>
						<div class="title">Info: <span class="star">*</span></div>
					</div>
<?php $ulink = ($route[1]=="add") ? ahref(array($route[0], 'add')) : ahref(array($route[0], 'edit', $id)); ?>
	                <form id="catform" method="post" action="<?php echo $ulink;?>">
                   		<input type="hidden" name="params_form_perform" value="1" />
                        <input type="hidden" name="tabstop" id="tabstop" value="main" />
<?php if($route[1]=="add"): ?>
					<?php if ($route[0] == 'settings' || $route[0] == 'langdata'): ?>
                        <div class="list fix">
                            <div class="name"><?php echo a('key');?> <span class="star">*</span></div>
                            <input type="text" id="key" name="key" value="<?php echo ($route[1]=="edit") ? $key : '' ;?>" class="inp"/>
                        </div>
					<?php endif ?>
                        <div class="list fix">
                            <div class="name"><?php echo a('title');?>: <span class="star">*</span></div>
                            <input type="text" id="title" name="title" value="<?php echo ($route[1]=="edit") ? $title : '' ;?>" class="inp"/>
                        </div>
<?php else: ?>
					<?php if ($route[0] == 'settings' || $route[0] == 'langdata'): ?>
                        <input type="hidden" id="key" name="key" value="<?php echo ($route[1]=="edit") ? $key : '' ;?>" class="inp"/>
					<?php endif ?>
                    <?php
		            	if ($_SESSION['auth']["class"]==0):
		            ?>
                        <div class="list fix">
                            <div class="name"><?php echo a('title');?>: <span class="star">*</span></div>
                            <input type="text" id="title" name="title" value="<?php echo ($route[1]=="edit") ? $title : '' ;?>" class="inp"/>
                        </div>
                    <?php else: ?>
                            <input type="hidden" id="title" name="title" value="<?php echo ($route[1]=="edit") ? $title : '' ;?>" class="inp"/>
                    <?php endif; ?>
<?php endif; ?>
                        <div class="list2 fix">
                            <div class="name"><?php echo a('value');?>: <span class="star">*</span></div>
                            <input type="text" id="value" name="value" value="<?php echo ($route[1]=="edit") ? $value : '' ;?>" class="inp"/>
                        </div>
                   <?php if ($route[0] == 'menutype'): ?>
                        <div class="list fix">
                            <div class="name">კატეგორია: <span class="star">*</span></div>
                            <select name="cat" id="cat" class="inp-small" style="width:210px;margin-right:10px;">
                                <option value="0"></option>
                            <?php
                                $cats = db_fetch_all("SELECT * from obj_cats where deleted=0 and language='".l()."'");
                                foreach ($cats as $item):
                            ?>
                                <option value="<?php echo $item["id"] ?>"<?php echo ($route[1]=='edit' && $item["id"] == $cat) ? ' selected' : '' ?>><?php echo $item["title"] ?></option>
                            <?php endforeach ?>
                            </select>
                        </div>
                   <?php endif ?>
                   <?php if ($route[0] == 'cats'): ?>
                        <div class="list fix">
                            <div class="name">მომსახურების დასახელება: <span class="star">*</span></div>
                            <input type="text" id="value" name="serv_title" value="<?php echo ($route[1]=="edit") ? $serv_title : '' ;?>" class="inp"/>
                        </div>
                   <?php endif ?>
					</form>
				</div>
				<div id="bottom" class="fix">
	                <a href="javascript:save('edit');" class="button br"><?php echo a("save");?></a>
	                <a href="javascript:save('close');" class="button br"><?php echo a("save&close");?></a>
	                <a href="<?php echo ahref(array($route[0]));?>" class="button br"><?php echo a("cancel");?></a>
				</div>
			</div>
		</div>
<script language="javascript">
	function save(action) {
        $("#tabstop").val(action);
		var validate = 1;
		var msg = "";
        if($("#pagetitle").val()=='') {
            msg = "<?php echo a('error.title');?>";
            validate = 0;
        }
		if(validate == 1) {
			this.catform.submit();
		} else {
			alert(msg);
		}
	}

    function nextlang(lang) {
        save(lang);
    }
</script>