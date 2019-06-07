<?php defined('DIR') OR exit;
    $parent_slug = '/';
    if ($route[1] == 'edit') {
        if ($edit["masterid"]!=0){
            $parent_slug .= db_retrieve('slug', c("table.pages"), 'idx', $edit["masterid"]);
        } elseif ($menuid!=0) {
            $parent_slug = db_retrieve('slug', c("table.pages"), 'menutype', $menuid);
            $parent_slug = $parent_slug ? '/'.$parent_slug : '';
        } else {
            $parent_slug = '';
        }
        $level = $edit["level"];
    } else {
        if (get('id',0)!=0) {
            $sql = db_fetch("SELECT slug, level from ".c("table.pages")." where id={$_GET['id']}");
            $parent_slug .= $sql["slug"];
            $level = $sql["level"] + 1;
            $params['id'] = $_GET["id"];
        } elseif ($menuid!=0) {
            $parent_slug = db_retrieve('slug', c("table.pages"), 'menutype', $menuid);
            $parent_slug = $parent_slug ? '/'.$parent_slug : '';
            $level = 1;
        } else {
            $parent_slug = '';
            $level = 1;
        }
    }
?>
    <div id="title" class="fix">
        <div class="icon"><img src="_tripadmin/img/edit.png" width="16" height="16" alt="" /></div>
        <div class="name"><?php echo $pagetitle . ': ' . (($route[1] == 'edit') ? $edit["title"] : a('add')); ?></div>
    </div>
    
    <div id="box">
        <div id="part">
            <div id="top" class="fix">
                <a href="javascript:v_general();" id="b1" class="selbutton br"><?php echo a("general");?></a>
                <a href="javascript:v_content();" id="b2" class="button br"><?php echo a("content");?></a>
<?php if($route[1]=='edit'):
    if(in_array($edit["category"], array(8,9,10,11,12,13,14,15,16,17))):
        switch($edit["category"]) {
            case 8:  $menucat = "news"; $btitle = a("bt.news"); break;
            case 9:  $menucat = "articles"; $btitle = a("bt.articles"); break;
            case 10: $menucat = "events"; $btitle = a("bt.events"); break;
            case 11: $menucat = "customlist"; $btitle = a("bt.list"); break;
            case 12: $menucat = "imagegallery"; $btitle = a("bt.imagegallery"); break;
            case 13: $menucat = "videogallery"; $btitle = a("bt.videogallery"); break;
            case 14: $menucat = "audiogallery"; $btitle = a("bt.audiogallery"); break;
            case 15: $menucat = "poll"; $btitle = a("bt.polls"); break;
            case 16: $menucat = "catalog"; $btitle = a("bt.catalogs"); break;
            case 17: $menucat = "faq"; $btitle = a("bt.faq"); break;
        }
?>
                <a href="<?php echo ahref(array($menucat, 'show', $edit["menutype"])) ?>" id="b3" class="button br"><?php echo $btitle;?></a>
<?php
    else:
?>
                <a href="javascript:save('files');" id="b3" class="button br"><?php echo a("files");?></a>
<?php
    endif;
    endif;
?>
            </div>
            <form id="dataform" name="dataform" method="post" action="<?php echo ahref($route, $params);?>">
            <div id="news">
                <div id="t1">
                    <input type="hidden" name="perform" value="1" />
                    <input type="hidden" name="menuid" value="<?php echo $menuid ?>" />
                    <input type="hidden" name="level" value="<?php echo $level ?>" />
                    <input type="hidden" name="tabstop" id="tabstop" value="general" />
                    <input type="hidden" name="lastupdate" value="<?php echo date('Y-m-d H:i:s') ?>" />
                    <div class="list2 fix">
                        <div class="icon"><img src="_tripadmin/img/minus.png" width="16" height="16" alt="" /></div>
                        <div class="title"><?php echo a("general");?>:</div>
                    </div>

                    <div class="list fix">
                        <div class="name"><?php echo a("title");?>: <span class="star">*</span></div>
                        <input type="text" id="pagetitle" name="title" value="<?php echo ($route[1]=='edit') ? $edit["title"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">
                            <?php 
                            if(isset($edit["menuid"]) && $edit["menuid"]==34){
                                echo "Price";
                            }else if(isset($edit["menuid"]) && $edit["menuid"]==40){
                                echo 'Beetrip კმ. ფასი 0-49';
                            }else{
                                echo a("menutitle");
                            }
                            ?>: <span class="star">*</span></div>
                        <input type="text" id="menutitle" name="menutitle" value="<?php echo ($route[1]=='edit') ? $edit["menutitle"] : '' ?>" class="inp"/>
                    </div>

                    <!-- beetrip prices start-->
                    <?php if(isset($edit["menuid"]) && $edit["menuid"]==40): ?>
                    <div class="list2 fix">
                        <div class="name">Beetrip კმ. ფასი 50-99: <span class="star">*</span></div>
                        <input type="text" id="menutitle2" name="menutitle2" value="<?php echo ($route[1]=='edit' && isset($edit["menutitle2"])) ? $edit["menutitle2"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">Beetrip კმ. ფასი 100-149: <span class="star">*</span></div>
                        <input type="text" id="menutitle3" name="menutitle3" value="<?php echo ($route[1]=='edit' && isset($edit["menutitle3"])) ? $edit["menutitle3"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">Beetrip კმ. ფასი 150-199: <span class="star">*</span></div>
                        <input type="text" id="menutitle4" name="menutitle4" value="<?php echo ($route[1]=='edit' && isset($edit["menutitle4"])) ? $edit["menutitle4"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">Beetrip კმ. ფასი 200-249: <span class="star">*</span></div>
                        <input type="text" id="menutitle5" name="menutitle5" value="<?php echo ($route[1]=='edit' && isset($edit["menutitle5"])) ? $edit["menutitle5"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">Beetrip კმ. ფასი 250-299: <span class="star">*</span></div>
                        <input type="text" id="menutitle6" name="menutitle6" value="<?php echo ($route[1]=='edit' && isset($edit["menutitle6"])) ? $edit["menutitle6"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">Beetrip კმ. ფასი 300-349: <span class="star">*</span></div>
                        <input type="text" id="menutitle7" name="menutitle7" value="<?php echo ($route[1]=='edit' && isset($edit["menutitle7"])) ? $edit["menutitle7"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">Beetrip კმ. ფასი 350-399: <span class="star">*</span></div>
                        <input type="text" id="menutitle8" name="menutitle8" value="<?php echo ($route[1]=='edit' && isset($edit["menutitle8"])) ? $edit["menutitle8"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">Beetrip კმ. ფასი 400+: <span class="star">*</span></div>
                        <input type="text" id="menutitle9" name="menutitle9" value="<?php echo ($route[1]=='edit' && isset($edit["menutitle9"])) ? $edit["menutitle9"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">Beetrip მგზ.მაქ.რაოდ.: <span class="star">*</span></div>
                        <input type="text" id="menutitle10" name="menutitle10" value="<?php echo ($route[1]=='edit' && isset($edit["menutitle10"])) ? $edit["menutitle10"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">Beetrip მოგების %: <span class="star">*</span></div>
                        <input type="text" id="menutitle11" name="menutitle11" value="<?php echo ($route[1]=='edit' && isset($edit["menutitle11"])) ? $edit["menutitle11"] : '' ?>" class="inp"/>
                    </div>

                    <!-- save way back discount Start -->
                    <div class="list2 fix" style="background-color: #90A4AE">
                        <div class="name" style="color:white">beetrip.ორმ.გზა.ფასდ.%<span class="star">*</span></div>
                        <input type="text" name="samewaydiscount2" value="<?php echo ($route[1]=='edit') ? $edit["samewaydiscount2"] : '' ?>" class="inp"/>
                    </div> 
                    <!-- save way back discount End -->

                    <?php endif; ?>
                    <!-- beetrip prices end-->

                    <!-- Transfers prices by KM start -->
                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანსფერი 0-49 <span class="star">*</span></div>
                        <input type="text" name="p_transfer_0_50" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_0_50"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანსფერი 50-99 <span class="star">*</span></div>
                        <input type="text" name="p_transfer_50_100" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_50_100"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანსფერი 100-149 <span class="star">*</span></div>
                        <input type="text" name="p_transfer_100_150" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_100_150"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანსფერი 150-199 <span class="star">*</span></div>
                        <input type="text" name="p_transfer_150_200" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_150_200"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანსფერი 200-249 <span class="star">*</span></div>
                        <input type="text" name="p_transfer_200_250" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_200_250"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანსფერი 250-299 <span class="star">*</span></div>
                        <input type="text" name="p_transfer_250_300" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_250_300"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანსფერი 300-349 <span class="star">*</span></div>
                        <input type="text" name="p_transfer_300_350" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_300_350"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანსფერი 350-399 <span class="star">*</span></div>
                        <input type="text" name="p_transfer_350_400" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_350_400"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანსფერი 400+ <span class="star">*</span></div>
                        <input type="text" name="p_transfer_400_plus" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_400_plus"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანს. მგზ.მაქ.რაოდ. <span class="star">*</span></div>
                        <input type="text" name="p_transfer_max_crowed" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_max_crowed"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #C4BCBC'?>">
                        <div class="name">Trip ტრანს. მოგების %. <span class="star">*</span></div>
                        <input type="text" name="p_transfer_income_proc" value="<?php echo ($route[1]=='edit') ? $edit["p_transfer_income_proc"] : '' ?>" class="inp"/>
                    </div> 
                    <!-- Transfers prices by KM end -->

                    <!-- Planner prices by KM Start -->
                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგმავი 0-49 <span class="star">*</span></div>
                        <input type="text" name="p_planner_0_50" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_0_50"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგმავი 50-99 <span class="star">*</span></div>
                        <input type="text" name="p_planner_50_100" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_50_100"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგმავი 100-149 <span class="star">*</span></div>
                        <input type="text" name="p_planner_100_150" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_100_150"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგმავი 150-199 <span class="star">*</span></div>
                        <input type="text" name="p_planner_150_200" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_150_200"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგმავი 200-249 <span class="star">*</span></div>
                        <input type="text" name="p_planner_200_250" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_200_250"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგმავი 250-299 <span class="star">*</span></div>
                        <input type="text" name="p_planner_250_300" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_250_300"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგმავი 300-349 <span class="star">*</span></div>
                        <input type="text" name="p_planner_300_350" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_300_350"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგმავი 350-399 <span class="star">*</span></div>
                        <input type="text" name="p_planner_350_400" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_350_400"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგმავი 400+ <span class="star">*</span></div>
                        <input type="text" name="p_planner_400_plus" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_400_plus"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგ. მგზ.მაქ.რაოდ.<span class="star">*</span></div>
                        <input type="text" name="p_planner_max_crowd" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_max_crowd"] : '' ?>" class="inp"/>
                    </div> 

                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #E5E4E4'?>">
                        <div class="name">Trip მგეგ. მოგების %<span class="star">*</span></div>
                        <input type="text" name="p_planner_income_proc" value="<?php echo ($route[1]=='edit') ? $edit["p_planner_income_proc"] : '' ?>" class="inp"/>
                    </div> 
                    <!-- Planner prices by KM end -->

                    <!-- ongoing max pessangers Start -->
                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #757575'?>">
                        <div class="name" style="color:white">Trip მზატურ. მგზ.რაოდ.<span class="star">*</span></div>
                        <input type="text" name="p_ongoing_max_crowd" value="<?php echo ($route[1]=='edit') ? $edit["p_ongoing_max_crowd"] : '' ?>" class="inp"/>
                    </div> 
                    <!-- ongoing max pessangers End -->

                    <!-- save way back discount Start -->
                    <div class="list2 fix" style="<?=(!isset($edit["menuid"]) || $edit["menuid"]!=40) ? 'visibility: hidden; position:absolute;' : 'background-color: #90A4AE'?>">
                        <div class="name" style="color:white">Trip ტრანსფ ორმ.გზა.ფასდ.%<span class="star">*</span></div>
                        <input type="text" name="samewaydiscount" value="<?php echo ($route[1]=='edit') ? $edit["samewaydiscount"] : '' ?>" class="inp"/>
                    </div> 
                    <!-- save way back discount End -->
                    

                    <div class="list fix">
                        <div class="name"><?php echo a("friendlyURL");?>: <span class="star">*</span></div>
                        <?php echo c('site.url') . l() . $parent_slug.'/'; ?>
                        <input type="text" name="slug" value="<?php echo ($route[1]=='edit') ? $edit["slug"] : '' ?>" class="inp-ssmall"/>
                        <?php echo ($route[1] == 'edit') ? '/'.$edit["id"] : '';?>
                    </div>
<?php
    isset($edit['category']) OR $edit['category'] = 1;
    $catchange_disabled = '';
    if(in_array($edit['category'], array('8','9','10','11','12','13','14','15','16',17))) $catchange_disabled = 'disabled';
    if($route[0] != 'sitemap') $catchange_disabled = 'disabled';
?>
                    <div class="list2 fix">
                        <div class="name"><?php echo a("pageclass");?>: <span class="star">*</span></div>
<script type="text/javascript">
    $(function(){
        $('#category_change').change(function(){
            var v = $(this).val();
            if (v=='7') {
                $('#category_7').show();
            } else {
                $('#category_7').hide();
            }
        });
    });
</script>
                        <select name="category" id="category_change" class="inp-small" style="width:210px;" <?php  echo $catchange_disabled; ?> >
                            <?php if (get('id',0)==1): ?>
                            <option value='2'  <?php if ($edit['category'] == '2') { echo 'selected'; } ?>><?php echo a("page.home");?></option>
                            <?php else: ?>
                            <option value='1' <?php if ($edit['category'] == '1') { echo 'selected'; } ?>><?php echo a("page.text");?></option>
                            <!-- <option value='8' <?php if ($edit['category'] == '8') { echo 'selected'; } ?>><?php echo a("page.news");?></option> -->
                            <!-- <option value='9' <?php if ($edit['category'] == '9') { echo 'selected'; } ?>><?php echo a("page.articles");?></option> -->
                            <!-- <option value='10' <?php if ($edit['category'] == '10'){ echo 'selected'; } ?>><?php echo a("page.events");?></option> -->
                            <option value='16' <?php if ($edit['category'] == '16'){ echo 'selected'; } ?>><?php echo a("page.catalog");?></option>
                            <!-- <option value='11' <?php if ($edit['category'] == '11') { echo 'selected'; } ?>><?php echo a("page.list");?></option> -->
                            <option value='12' <?php if ($edit['category'] == '12') { echo 'selected'; } ?>><?php echo a("page.photo");?></option>
                            <option value='6' <?php if ($edit['category'] == '6') { echo 'selected'; } ?>><?php echo a("page.feedback");?></option>
                            <option value='4' <?php if ($edit['category'] == '4') { echo 'selected'; } ?>><?php echo a("page.search");?></option>
                            <!-- <option value='5' <?php if ($edit['category'] == '5') { echo 'selected'; } ?>><?php echo a("page.sitemap");?></option> -->
                            <!-- <option value='17' <?php if ($edit['category'] == '17'){ echo 'selected'; } ?>><?php echo a("page.faq");?></option> -->
                            <!-- <option value='15' <?php if ($edit['category'] == '15'){ echo 'selected'; } ?>><?php echo a("page.poll");?></option> -->
                            <!-- <option value='13' <?php if ($edit['category'] == '13'){ echo 'selected'; } ?>><?php echo a("page.video");?></option> -->
                            <!-- <option value='14' <?php if ($edit['category'] == '14'){ echo 'selected'; } ?>><?php echo a("page.audio");?></option> -->
                            <!-- <option value='7'  <?php if ($edit['category'] == '7') { echo 'selected'; } ?>><?php echo a("page.plugin");?></option> -->
                            <!-- <option value='3'  <?php if ($edit['category'] == '3') { echo 'selected'; } ?>><?php echo a("page.about");?></option> -->
                            <?php endif ?>
                        </select>
                        <div style="float:left;display:none;">
                            <div class="name"><?php echo a("attachedtopic");?>: <span class="star">*</span></div>
                            <input name='menutype' id='menutype' type='text' class='inp-small' value='<?php echo isset($edit['menutype']) ? $edit['menutype'] : 0 ?>' />
                        </div>
                    </div>

                    <div class="list fix">
                        <div class="name"><?php echo a("date");?>: <span class="star">*</span></div>
                        <input type="text" name="postdate" value="<?php echo ($route[1]=='edit') ? date('Y-m-d', strtotime($edit["postdate"])) : date('Y-m-d'); ?>" id="postdate" class="inp-small" data-beatpicker="true" data-beatpicker-position="['*','*']" data-beatpicker-module="today,gotoDate,clear,icon" />
                        <div class="name"><?php echo a("time");?>: <span class="star">*</span></div>
                        <input type="text" name="posttime" value="<?php echo ($route[1]=='edit') ? date('H:i:s', strtotime($edit["postdate"])) : date('H:i:s'); ?>" id="posttime" class="inp-small" />
                    </div>
                    <div class="list2 fix">
                        <div class="name"><?php echo a("template");?>: <span class="star">*</span></div>
                            <select name="template" class="inp-small" style="width:210px;">
                                <option value=""></option>
<?php
        $templates=scandir(WEBSITE."/templates/custom");
        foreach($templates as $t) :
            if($t !='.' && $t !='..') :
                $tt = str_replace('.php','',$t);
?>
                                <option value="<?php echo $tt;?>" <?php echo ($route[1]=='edit' && $edit["template"]==$tt) ? 'selected="selected"' : ''; ?> ><?php echo ucfirst($tt);?></option>
<?php
        endif;
    endforeach;
?>
                            </select>
                    </div>

                    <div class="list fix">
                        <div class="name"><?php echo a("redirectlink");?>:</div>
                        <input type="text" name="redirectlink" value="<?php echo ($route[1]=='edit') ? $edit["redirectlink"] : '' ?>" class="inp-small" />
                    </div>

                    <div class="list2 fix">
                        <div class="name"><?php echo a("visibility");?>: <span class="star">*</span></div>
                        <input type="checkbox" name="visibility" class="inp-check"<?php echo (($route[1]=='edit')&&($edit["visibility"]==0)) ? '' : ' checked' ?> />
                    </div>

                    <div class="list fix">
                        <div class="name"><?php echo a("description");?> <span class="star">*</span></div>
                        <input type="text" name="meta_desc" value="<?php echo ($route[1]=='edit') ? $edit["meta_desc"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name"><?php echo a("keywords");?> <span class="star">*</span></div>
                        <input type="text" name="meta_keys" value="<?php echo ($route[1]=='edit') ? $edit["meta_keys"] : '' ?>" class="inp"/>
                    </div>
                    <div class="list fix">
                        <div class="name"><?php echo a("image");?>: <span class="star">*</span></div>
                        <input type="text" id="image1" name="image1" value="<?php echo ($route[1]=='edit') ? $edit["image1"] : '' ?>" class="inp" style="width:500px;" />
                        <a href="javascript:;" class="popup button br" data-browse="image1"><?php echo a('browse') ?></a>
                    </div>

                    
                    <div class="list2 fix" style="display:none;">
                        <div class="name"><?php echo a("image");?>: <span class="star">*</span></div>
                        <input type="text" id="image2" name="image2" value="<?php echo ($route[1]=='edit') ? $edit["image2"] : '' ?>" class="inp" style="width:500px;" />
                        <a href="javascript:;" class="popup button br" data-browse="image2"><?php echo a('browse') ?></a>
                    </div>
                </div>

                <div id="t2">
                    <div class="list fix">
                        <div class="icon"><img src="_tripadmin/img/minus.png" width="16" height="16" alt="" /></div>
                        <div class="title"><?php echo a("shorttext");?>:</div>
                    </div>

                    <div class="list2 fix">
                        <div class="name"><?php echo a("description");?>: <span class="star">*</span></div>
                        <div class="left" style="width:900px;">
                            <textarea name="description" class="editor" style="height:200px; margin-top:2px; margin-bottom:2px;"><?php echo ($route[1]=='edit') ? $edit["description"] : '' ?></textarea>
                        </div>
                    </div>
                    <div style="display:none">
	                    <div class="list fix">
	                        <div class="icon"><img src="_tripadmin/img/minus.png" width="16" height="16" alt="" /></div>
	                        <div class="title"><?php echo a("pagecontent");?>:</div>
	                    </div>
	                    <div class="list2 fix">
	                        <div class="name"><?php echo a("content");?>: <span class="star">*</span></div>
	                        <div class="left" style="width:900px;">
	                            <textarea name="content" class="editor" style="height:300px; margin-top:2px; margin-bottom:2px;"><?php echo ($route[1]=='edit') ? $edit["content"] : '' ?></textarea>
	                        </div>
	                    </div>
	                </div>    
                </div>
            </div>
            </form>
            <div id="bottom" class="fix">
                <a href="javascript:v_save('edit');" class="button br"><?php echo a("save");?></a>
                <a href="javascript:v_savenext('content');" class="button br"><?php echo a("save&next");?></a>
                <a href="javascript:save('close');" class="button br"><?php echo a("save&close");?></a>
                <a href="<?php echo ahref(array($route[0], 'show', $menuid));?>" class="button br"><?php echo a("cancel");?></a>
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
    
    $("#t2").hide();
    $("#t1").show();
    var section = 1;

    v_tabswitch("<?php echo (isset($_GET["tabstop"])) ? $_GET["tabstop"] : 'general';?>");

    function v_tabswitch(i) {
        if(i=='general') { v_general() }
        if(i=='content') { v_content() }
    }

    function v_general() {
        $("#t1").hide();
        $("#t2").hide();
        $("#t1").show();
        section = 1;
        $('#b1').removeClass('button');
        $('#b2').removeClass('selbutton');
        $('#b1').addClass('selbutton');
        $('#b2').addClass('button');
        setFooter();
    }

    function v_content() {
        $("#t1").hide();
        $("#t2").hide();
        $("#t2").show();
        section = 2;
        $('#b1').removeClass('selbutton');
        $('#b2').removeClass('button');
        $('#b1').addClass('button');
        $('#b2').addClass('selbutton');
        setFooter();
    }

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
            document.dataform.submit();
        } else {
            alert(msg);
        }

    }

    function v_save() {
        if(section == 1) save('general');
        if(section == 2) save('content');
    }

    function v_savenext() {
        save('content')
    }

    function files() {
        save('files');
    }

    function nextlang(lang) {
        save(lang);
    }
</script>