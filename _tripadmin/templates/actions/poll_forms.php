    <div id="title" class="fix">
        <div class="icon"><img src="_tripadmin/img/edit.png" width="16" height="16" alt="" /></div>			
        <div class="name"><?php echo ($subaction=='add') ? a('addanswer') : a('editanswer');?></div>
    </div>	

    <div id="box">
        <div id="part">
            <div id="top" class="fix">
            </div>	
            
            <div id="t1" style="display:inline; visibility:visible;">
                <div id="news">
<?php $ulink = ($subaction=="add") ? ahref('poll', 'add', array('menu' => $menu)) : ahref('poll', 'edit', array('menu' => $menu, 'idx' => $idx)); ?>
                <form id="catform" name="catform" method="post" action="<?php echo $ulink;?>">
                   	<input type="hidden" name="poll_form_perform" value="1" />
                        <div class="list2 fix">
                            <div class="icon"><a href="#"><img src="_tripadmin/img/minus.png" width="16" height="16" alt="" /></a></div>								
                            <div class="title"><?php echo a("info");?>: <span class="star">*</span></div>								
                        </div>		
        
                        <div class="list fix">
                            <div class="name"><?php echo a("answer");?>: <span class="star">*</span></div>					
                            <input type="text" id="pagetitle" name="answer" value="<?php echo ($subaction=='edit') ? $answer : '' ?>" class="inp"/>
                        </div>	
        
                        <div class="list2 fix">
                            <div class="name" style="line-height:16px;"><?php echo a("answercount");?>: <span class="star">*</span></div>					
                            <input type="text" id="answercount" name="answercount" value="<?php echo ($subaction=='edit') ? $answercount : '' ?>" class="inp-small"/>
                        </div>	
        
                        <div class="list fix">
                            <div class="name"><?php echo a("answercounttotal");?>: <span class="star">*</span></div>					
                            <input type="text" id="answercounttotal" name="answercounttotal" value="<?php echo ($subaction=='edit') ? $answercounttotal : '' ?>" class="inp-small"/>
                        </div>	
                        
                        <div class="list2 fix">
                            <div class="name"><?php echo a("visibility");?>: <span class="star">*</span></div>
                            <input type="checkbox" name="visibility" class="inp-check"<?php echo (($subaction=='edit')&&($visibility==0)) ? '' : ' checked' ?> />
                        </div>	
        			</form>
                </div>
            </div>
            
            <div id="bottom" class="fix">
                <a href="javascript:save();" class="button br"><?php echo a("save");?></a>
                <a href="javascript:history.back(-1);" class="button br"><?php echo a("cancel");?></a>
            </div>					
        </div>		
    </div>
    <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>calendar/calendar-mos.css" title="green" media="all" />
<script language="javascript" type="text/javascript">
	function save() {
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
</script>