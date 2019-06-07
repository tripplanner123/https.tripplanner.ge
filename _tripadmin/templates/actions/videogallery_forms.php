<?php defined('DIR') OR exit; ?>
    <div id="title" class="fix">
        <div class="icon"><img src="_tripadmin/img/buttons/_camera.png" width="16" height="16" alt="" /></div>
        <div class="name"><?php echo a("imagegallery");?>: <?php echo ($route[1] == 'edit') ? $pagetitle.' - '.a('ql.edit') : $pagetitle.' - '.a('add'); ?></div>
    </div>

    <div id="box">
        <div id="part">
            <div id="top" class="fix">
            </div>

            <div id="t1" style="display:inline; visibility:visible;">
                <div id="news">
<?php $ulink = ($route[1]=="add") ? ahref(array($route[0], 'add', $menuid)) : ahref(array($route[0], 'edit', $id)); ?>
                <form id="catform" name="catform" method="post" action="<?php echo $ulink;?>">
                    <input type="hidden" name="tabstop" id="tabstop" value="edit" />
                    <input type="hidden" name="menuid" value="<?php echo $menuid ?>" />
                        <div class="list2 fix">
                            <div class="icon"><a href="#"><img src="_tripadmin/img/minus.png" width="16" height="16" alt="" /></a></div>
                            <div class="title"><?php echo a("info");?>: <span class="star">*</span></div>
                        </div>

                        <div class="list2 fix">
                            <div class="name"><?php echo a("title");?>: <span class="star">*</span></div>
                            <input type="text" id="pagetitle" name="title" value="<?php echo ($route[1]=='edit') ? $title : '' ?>" class="inp"/>
                        </div>

                        <div class="list fix">
                            <div class="name"><?php echo a("date");?>: <span class="star">*</span></div>
                            <input type="text" name="postdate" value="<?php echo ($route[1]=='edit') ? date('Y-m-d', strtotime($postdate)) : date('Y-m-d'); ?>" id="postdate" class="inp-small" />
<script language="JavaScript">
    new tcal ({
        'formname': 'catform',
        'controlname': 'postdate',
    });
</script>
                            <div class="name"><?php echo a("time");?>: <span class="star">*</span></div>
                            <input type="text" name="posttime" value="<?php echo ($route[1]=='edit') ? date('H:i:s', strtotime($postdate)) : date('H:i:s'); ?>" id="posttime" class="inp-small" />
                        </div>

                        <div class="list2 fix">
                            <div class="name">Video: <span class="star">*</span></div>
                            <input type="text" id="link1" name="link" value="<?php echo ($route[1]=='edit') ? $link : '' ?>" class="inp" style="width:500px;"/>
                        </div>

                        <div class="list2 fix">
                            <div class="name">Author: <span class="star">*</span></div>
                            <input type="text" id="author" name="author" value="<?php echo ($route[1]=='edit') ? $author : '' ?>" class="inp" style="width:500px;"/>
                        </div>

                        <div class="list2 fix">
                            <div class="name">Keywords: <span class="star">*</span></div>
                            <input type="text" id="meta_keys" name="meta_keys" value="<?php echo ($route[1]=='edit') ? $meta_keys : '' ?>" class="inp" style="width:500px;"/>
                        </div>

                    <div class="list2 fix">
                        <div class="name"><?php echo a("description");?>: <span class="star">*</span></div>
                        <div class="left" style="width:900px;">
                            <textarea name="description" class="editor" style="height:200px; margin-top:2px; margin-bottom:2px;"><?php echo ($route[1]=='edit') ? $description : '' ?></textarea>
                        </div>
                    </div>

                        <div class="list fix">
                            <div class="name">Image: <span class="star">*</span></div>
                            <input type="text" id="image1" name="image1" value="<?php echo ($route[1]=='edit') ? $image1 : '' ?>" class="inp" style="width:500px;" />
                            <a href="#" class="popup button br" data-browse="image1"><?php echo a('browse') ?></a>
                        </div>

                        <div class="list2 fix">
                            <div class="name"><?php echo a("visibility");?>: <span class="star">*</span></div>
                            <input type="checkbox" name="visibility" class="inp-check"<?php echo (($route[1]=='edit')&&($visibility==0)) ? '' : ' checked' ?> />
                        </div>
                    </form>
                </div>
            </div>
            <div id="bottom" class="fix">
                <a href="javascript:save('edit');" class="button br"><?php echo a("save");?></a>
                <a href="javascript:save('close');" class="button br"><?php echo a("save&close");?></a>
                <a href="<?php echo ahref(array($route[0], 'show', $menuid)); ?>" class="button br"><?php echo a("cancel");?></a>
            </div>
        </div>
    </div>
<script language="javascript" type="text/javascript">
    $('.popup').on('click', function(e){
        id = $(this).data('browse');
        $.fancybox({
            width    : 900,
            height   : 600,
            type     : 'iframe',
            href     : '<?php echo JAVASCRIPT ?>/tinymce/filemanager/dialog.php?field_id='+id,
            autoSize : false
        });
        e.preventDefault();
    });
    
    function save(action) {
        $("#tabstop").val(action);
        var validate = 0;
        var msg = "";
        if($("#pagetitle").val()=='') {
            msg = "<?php echo a('error.title');?>";
            validate = 0;
        } else {
            validate = 1;
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