<?php defined('DIR') OR exit;
    $parent_slug = db_retrieve('slug', c("table.pages"), 'menutype', $menuid);
?>
    <div id="title" class="fix">
        <div class="icon"><img src="_tripadmin/img/edit.png" width="16" height="16" alt="" /></div>
        <div class="name"><?php echo a("catalogs");?>: <?php echo ($route[1] == 'edit') ? $pagetitle.' - '.a('ql.edit') : $pagetitle.' - '.a('add'); ?></div>
    </div>
    <div id="box">
        <div id="part"> 

<?php $ulink = ($route[1]=="add") ? ahref(array($route[0], 'add', $menuid)) : ahref(array($route[0], 'edit', $id)); 
?>
            <div id="news">
                <form id="catform" name="catform" method="post" action="<?php echo $ulink;?>">
                    <div id="general">
                        <input type="hidden" name="tabstop" id="tabstop" value="edit" />
                        <input type="hidden" name="menuid" value="<?php echo $menuid ?>" />
                        <div class="list fix">
                            <div class="icon"><a href="#"><img src="_tripadmin/img/minus.png" width="16" height="16" alt="" /></a></div>
                            <div class="title"><?php echo a("info");?>: <span class="star">*</span></div>
                        </div>


                        <div class="list2 fix">
                            <div class="name"><?php echo a("title");?>: <span class="star">*</span></div>
                            <input type="text" id="title" name="title" value="<?php echo ($route[1]=='edit') ? htmlentities($title) : '' ?>" class="inp"/>
                        </div>

                        <div class="list fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("friendlyURL");?>:</div>
                            <?php echo c('site.url') . l() .'/'. $parent_slug.'/'; ?>
                            <input type="text" id="slug" name="slug" value="<?php echo ($route[1]=='edit') ? htmlentities($slug) : '' ?>" class="inp-ssmall" />
                            <?php echo ($route[1] == 'edit') ? '/'.$id : '';?>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("date");?>: <span class="star">*</span></div>
                            <input type="text" name="postdate" value="<?php echo ($route[1]=='edit') ? date('Y-m-d', strtotime($postdate)) : date('Y-m-d'); ?>" id="postdate" class="inp-small" />
                            <div class="name"><?php echo a("time");?>: <span class="star">*</span></div>
                            <input type="text" name="posttime" value="<?php echo ($route[1]=='edit') ? date('H:i:s', strtotime($postdate)) : date('H:i:s'); ?>" id="posttime" class="inp-small" />
                        </div>


                        <div class="list fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">აირჩიეთ რეგიონი: </div>    
                            <div style="float: left; width:800px">
                                <?php 
                                $regions_array = (!empty($regions)) ? explode(",", $regions) : array();
                                foreach ($regions_list as $reg): 
                                    $checked = ($subaction=='edit' && in_array($reg["id"], $regions_array)) ? 'checked="checked" ' : ''; 
                                ?>            
                                    <div class="name" style="width: 200px;">
                                        <label style="cursor: pointer"><?=$reg["menutitle"]?> 
                                            <input type="checkbox" name="regions[]" value="<?=$reg["id"]?>" <?=$checked?>/>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div> 

                        <div class="list fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">აირჩიეთ კატეგორია: </div>    
                            <div style="float: left; width:800px">
                                <?php 
                                $categories_array = (!empty($categories)) ? explode(",", $categories) : array();
                                foreach ($categories_list as $cat): 
                                    $checked = ($subaction=='edit' && in_array($cat["id"], $categories_array)) ? 'checked="checked" ' : ''; 
                                ?>            
                                    <div class="name" style="width: 200px;">
                                        <label style="cursor: pointer"><?=$cat["title"]?> 
                                            <input type="checkbox" name="categories[]" value="<?=$cat["id"]?>" <?=$checked?>/>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div> 

                        <div class="list2 fix" style="border:solid 1px #555555; margin:10px 0; padding: 10px 20px; <?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="placesbox">
                                <?php if($subaction=='edit'): 
                                if(preg_match_all("/\[(\d+)\]/", $places, $matches)){
                                    $x = 0;
                                    foreach ($matches[1] as $v) {
                                        $fetch = g_get_place_by_id($v);
                                        echo sprintf(
                                            '<div class="place-item hidden%s">%s<i data-id="%s">x</i></div>', 
                                            $v,
                                            $fetch['title'],
                                            $v
                                        );
                                        $x++;
                                    }
                                }
                                ?>
                                <?php endif; ?>
                            </div>
                            <div class="clearer"></div>
                            <div class="name">დაამატე ადგილები:</div>
                            
                            <select name="places" id="places" class="inp-small" style="width:210px; margin-right: 20px;">
                                <option value="">&nbsp;</option>
                                <?php foreach(g_places_admin() as $v): ?>
                                <option value="<?=$v['id']?>"><?=$v['title']?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- <input type="text" name="place-day" id="place-day" value="" class="inp" placeholder="დღე" style="width:210px; margin-right: 20px;" /> -->
                            <!-- <input type="text" name="place-price" id="place-price" value="" class="inp" placeholder="ფასი" style="width:210px; margin-right: 20px;" /> -->
                            <button class="addPlace" type="button">დამატება</button>
                        </div>

                    
                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                           
                            <div class="name">დღეების რაოდენობა:</div>
                            <input type="text" name="total_dayes" value="<?php echo ($route[1]=='edit') ? $total_dayes : '' ?>" class="inp"/>
                            
                        </div>

                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">რეიტინგი:</div>
                            <select name="reiting" id="reiting" class="inp-small" style="width:210px;">
                                <option value="1"<?php echo ($subaction=='edit' && $reiting==1) ? " selected='selected'" : ""?>>1 ვარსკვლავი</option>
                                <option value="2"<?php echo ($subaction=='edit' && $reiting==2) ? " selected='selected'" : ""?>>2 ვარსკვლავი</option>
                                <option value="3"<?php echo ($subaction=='edit' && $reiting==3) ? " selected='selected'" : ""?>>3 ვარსკვლავი</option>
                                <option value="4"<?php echo ($subaction=='edit' && $reiting==4) ? " selected='selected'" : ""?>>4 ვარსკვლავი</option>
                                <option value="5"<?php echo ($subaction=='edit' && $reiting==5) ? " selected='selected'" : ""?>>5 ვარსკვლავი</option>
                            </select>
                        </div>




                        <div class="list fix" style="<?=($menuid==47 || $menuid==42 || $menuid==24) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">Price</div>
                            <input type="text" name="price" value="<?php echo ($route[1]=='edit') ? $price : '' ?>" class="inp"/>
                        </div>

                        <?php if($menuid == 24) : ?>
                        <div class="list fix">
                            <div class="icon"><a href="#"><img src="_tripadmin/img/minus.png" width="16" height="16" alt="" /></a></div>
                            <div class="title">მზა ტურის ფასის გამოთვლა: <span class="star">*</span></div>
                        </div>

                        <div class="list fix">
                            <div class="name">მთლიანი ფასი სედანი</div>
                            <input type="text" name="price_sedan" value="<?php echo ($route[1]=='edit' && isset($price_sedan)) ? $price_sedan : '' ?>" class="inp" />
                        </div>

                        <div class="list fix">
                            <div class="name">ტურ. მინ. რაო. BEP. სედანი</div>
                            <input type="text" name="guest_sedan" value="<?php echo ($route[1]=='edit' && isset($guest_sedan)) ? $guest_sedan : '' ?>" class="inp" />
                        </div>

                        <div class="list fix">
                            <div class="name">მთლიანი ფასი მინივენი</div>
                            <input type="text" name="price_minivan" value="<?php echo ($route[1]=='edit' && isset($price_minivan)) ? $price_minivan : '' ?>" class="inp" />
                        </div>

                        <div class="list fix" style="visibility:hidden; position:absolute">
                            <div class="name">ტურ. მინ. რაო. BEP. მინივენი</div>
                            <input type="text" name="guest_minivan" value="<?php echo ($route[1]=='edit' && isset($guest_minivan)) ? $guest_minivan : '' ?>" class="inp" />
                        </div>

                        <div class="list fix">
                            <div class="name">მთლიანი ფასი მინიბუსი</div>
                            <input type="text" name="price_minibus" value="<?php echo ($route[1]=='edit' && isset($price_minibus)) ? $price_minibus : '' ?>" class="inp" />
                        </div>

                        <div class="list fix">
                            <div class="name">მთლიანი ფასი ავტობუსი</div>
                            <input type="text" name="price_bus" value="<?php echo ($route[1]=='edit' && isset($price_bus)) ? $price_bus : '' ?>" class="inp" />
                        </div>

                        <div class="list fix" style="visibility:hidden; position:absolute">
                            <div class="name">ტურ. მინ. რაო. BEP. ავტობუსი</div>
                            <input type="text" name="guest_bus" value="<?php echo ($route[1]=='edit' && isset($guest_bus)) ? $guest_bus : '' ?>" class="inp" />
                        </div>

                        <div class="list fix">
                            <div class="name">მარჟა %</div>
                            <input type="text" name="tour_margin" value="<?php echo ($route[1]=='edit' && isset($tour_margin)) ? $tour_margin : '' ?>" class="inp" />
                        </div>

                        <div class="list fix">
                            <div class="name">მოგების %</div>
                            <input type="text" name="tour_income_margin" value="<?php echo ($route[1]=='edit' && isset($tour_income_margin)) ? $tour_income_margin : '' ?>" class="inp" />
                        </div>
                        

                        <div class="list fix">
                            <div class="name">კვების ღირებულება</div>
                            <input type="text" name="cuisune_price1person" value="<?php echo ($route[1]=='edit' && isset($cuisune_price1person)) ? $cuisune_price1person : '' ?>" class="inp" />
                        </div>

                        <div class="list fix">
                            <div class="name">ბილეთ. სხვა ხარჯი</div>
                            <input type="text" name="ticketsandother_price1person" value="<?php echo ($route[1]=='edit' && isset($ticketsandother_price1person)) ? $ticketsandother_price1person : '' ?>" class="inp" />
                        </div>

                        <div class="list fix">
                            <div class="name">სასტუმრო</div>
                            <input type="text" name="hotelpricefortour" value="<?php echo ($route[1]=='edit' && isset($hotelpricefortour)) ? $hotelpricefortour : '' ?>" class="inp" />
                        </div>

                        <div class="list fix">
                            <div class="name">გიდი</div>
                            <input type="text" name="guidepricefortour" value="<?php echo ($route[1]=='edit' && isset($guidepricefortour)) ? $guidepricefortour : '' ?>" class="inp" />
                        </div>

                        

                        <?php endif; ?>


                        

                        <div class="list fix">
                            <div class="icon"><a href="#"><img src="_tripadmin/img/minus.png" width="16" height="16" alt="" /></a></div>
                            <div class="title"><?php echo a("general");?>: <span class="star">*</span></div>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name" style="line-height:16px;">Overview: <span class="star">*</span></div>
                            <div class="left" style="width:900px;">
                                <textarea name="overview" class="editor" style="height:200px; margin-top:2px; margin-bottom:2px;"><?php echo ($route[1]=='edit') ? $overview : '' ?></textarea>
                            </div>
                        </div>

                        <div class="list2 fix" style="margin-top: 20px; <?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name" style="line-height:16px;">General Description: <span class="star">*</span></div>
                            <div class="left" style="width:900px;">
                                <textarea name="description" class="editor" style="height:200px; margin-top:2px; margin-bottom:2px;"><?php echo ($route[1]=='edit') ? $description : '' ?></textarea>
                            </div>
                        </div>

                        
                        <div class="list2 fix" style="margin-top: 20px; <?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name" style="line-height:16px;">Includes: <span class="star">*</span></div>
                            <div class="left" style="width:900px;">
                                <textarea name="includes2" class="editor" style="height:200px; margin-top:2px; margin-bottom:2px;"><?php echo ($route[1]=='edit') ? $includes : '' ?></textarea>
                            </div>
                        </div>

                        

                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("description");?></div>
                            <input type="text" name="meta_desc" value="<?php echo ($route[1]=='edit') ? $meta_desc : '' ?>" class="inp"/>
                        </div>

                        <div class="list fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("keywords");?></div>
                            <input type="text" name="meta_keys" value="<?php echo ($route[1]=='edit') ? $meta_keys : '' ?>" class="inp"/>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("image");?> 1: <span class="star">*</span></div>
                            <input type="text" id="image1" name="image1" value="<?php echo ($route[1]=='edit') ? $image1 : '' ?>" class="inp" style="width:500px;" />
                            <a href="javascript:;" class="popup button br" data-browse="image1"><?php echo a('browse') ?></a>
                            <a href="javascript:$('#image1').val(''); $('#image1_src').remove();" class="button br">remove</a>
                            <?php if($route[1]=='edit' && !empty($image1)): ?>
                            <div id="image1_src" style="clear: both;">
                                <div class="name">&nbsp;</div>                                
                                <img src="<?=$image1?>" width="150" />                                
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("image");?> 2: <span class="star">*</span></div>
                            <input type="text" id="image2" name="image2" value="<?php echo ($route[1]=='edit') ? $image2 : '' ?>" class="inp" style="width:500px;" />
                            <a href="javascript:;" class="popup button br" data-browse="image2"><?php echo a('browse') ?></a>
                            <a href="javascript:$('#image2').val(''); $('#image2_src').remove();" class="button br">remove</a>
                            <?php if($route[1]=='edit' && !empty($image2)): ?>
                            <div id="image2_src" style="clear: both;">
                                <div class="name">&nbsp;</div>                                
                                <img src="<?=$image2?>" width="150" />                                
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("image");?> 3: <span class="star">*</span></div>
                            <input type="text" id="image3" name="image3" value="<?php echo ($route[1]=='edit') ? $image3 : '' ?>" class="inp" style="width:500px;" />
                            <a href="javascript:;" class="popup button br" data-browse="image3"><?php echo a('browse') ?></a>
                            <a href="javascript:$('#image3').val(''); $('#image3_src').remove();" class="button br">remove</a>
                            <?php if($route[1]=='edit' && !empty($image3)): ?>
                            <div id="image3_src" style="clear: both;">
                                <div class="name">&nbsp;</div>                                
                                <img src="<?=$image3?>" width="150" />                                
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("image");?> 4: <span class="star">*</span></div>
                            <input type="text" id="image4" name="image4" value="<?php echo ($route[1]=='edit') ? $image4 : '' ?>" class="inp" style="width:500px;" />
                            <a href="javascript:;" class="popup button br" data-browse="image4"><?php echo a('browse') ?></a>
                            <a href="javascript:$('#image4').val(''); $('#image4_src').remove();" class="button br">remove</a>
                            <?php if($route[1]=='edit' && !empty($image4)): ?>
                            <div id="image4_src" style="clear: both;">
                                <div class="name">&nbsp;</div>                                
                                <img src="<?=$image4?>" width="150" />                                
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("image");?> 5: <span class="star">*</span></div>
                            <input type="text" id="image5" name="image5" value="<?php echo ($route[1]=='edit') ? $image5 : '' ?>" class="inp" style="width:500px;" />
                            <a href="javascript:;" class="popup button br" data-browse="image5"><?php echo a('browse') ?></a>
                            <a href="javascript:$('#image5').val(''); $('#image5_src').remove();" class="button br">remove</a>
                            <?php if($route[1]=='edit' && !empty($image5)): ?>
                            <div id="image5_src" style="clear: both;">
                                <div class="name">&nbsp;</div>                                
                                <img src="<?=$image5?>" width="150" />                                
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("image");?> 6: <span class="star">*</span></div>
                            <input type="text" id="image6" name="image6" value="<?php echo ($route[1]=='edit') ? $image6 : '' ?>" class="inp" style="width:500px;" />
                            <a href="javascript:;" class="popup button br" data-browse="image6"><?php echo a('browse') ?></a>
                            <a href="javascript:$('#image6').val(''); $('#image6_src').remove();" class="button br">remove</a>
                            <?php if($route[1]=='edit' && !empty($image6)): ?>
                            <div id="image6_src" style="clear: both;">
                                <div class="name">&nbsp;</div>                                
                                <img src="<?=$image6?>" width="150" />                                
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("image");?> 7: <span class="star">*</span></div>
                            <input type="text" id="image7" name="image7" value="<?php echo ($route[1]=='edit') ? $image7 : '' ?>" class="inp" style="width:500px;" />
                            <a href="javascript:;" class="popup button br" data-browse="image7"><?php echo a('browse') ?></a>
                            <a href="javascript:$('#image7').val(''); $('#image7_src').remove();" class="button br">remove</a>
                            <?php if($route[1]=='edit' && !empty($image7)): ?>
                            <div id="image7_src" style="clear: both;">
                                <div class="name">&nbsp;</div>                                
                                <img src="<?=$image7?>" width="150" />                                
                            </div>
                            <?php endif; ?>
                        </div>

                         <div class="list2 fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("image");?> 8: <span class="star">*</span></div>
                            <input type="text" id="image8" name="image8" value="<?php echo ($route[1]=='edit') ? $image8 : '' ?>" class="inp" style="width:500px;" />
                            <a href="javascript:;" class="popup button br" data-browse="image8"><?php echo a('browse') ?></a>
                            <a href="javascript:$('#image8').val(''); $('#image8_src').remove();" class="button br">remove</a>
                            <?php if($route[1]=='edit' && !empty($image8)): ?>
                            <div id="image8_src" style="clear: both;">
                                <div class="name">&nbsp;</div>                                
                                <img src="<?=$image8?>" width="150" />                                
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("image");?> 9: <span class="star">*</span></div>
                            <input type="text" id="image9" name="image9" value="<?php echo ($route[1]=='edit') ? $image9 : '' ?>" class="inp" style="width:500px;" />
                            <a href="javascript:;" class="popup button br" data-browse="image9"><?php echo a('browse') ?></a>
                            <a href="javascript:$('#image9').val(''); $('#image9_src').remove();" class="button br">remove</a>
                            <?php if($route[1]=='edit' && !empty($image9)): ?>
                            <div id="image9_src" style="clear: both;">
                                <div class="name">&nbsp;</div>                                
                                <img src="<?=$image9?>" width="150" />                                
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="list2 fix" style="<?=($menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name"><?php echo a("image");?> 10: <span class="star">*</span></div>
                            <input type="text" id="image10" name="image10" value="<?php echo ($route[1]=='edit') ? $image10 : '' ?>" class="inp" style="width:500px;" />
                            <a href="javascript:;" class="popup button br" data-browse="image10"><?php echo a('browse') ?></a>
                            <a href="javascript:$('#image10').val(''); $('#image10_src').remove();" class="button br">remove</a>
                            <?php if($route[1]=='edit' && !empty($image10)): ?>
                            <div id="image10_src" style="clear: both;">
                                <div class="name">&nbsp;</div>                                
                                <img src="<?=$image10?>" width="150" />                                
                            </div>
                            <?php endif; ?>
                        </div>

                        

                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">სტატუსი: <span class="star" title="<?php echo a('tt.visibility');?>">*</span></div>
                            <input type="checkbox" name="visibility" class="inp-check"<?php echo (($route[1]=='edit')&&($visibility==0)) ? '' : ' checked' ?> />
                        </div>

                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">დაწყების ადგილი:</div>
                            <input type="checkbox" name="startedplace" class="inp-check"<?php echo (($route[1]=='edit')&&($startedplace==0)) ? '' : ' checked' ?> />
                        </div>

                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">მგეგმავი:</div>
                            <input type="checkbox" name="planner_show" class="inp-check"<?php echo (($route[1]=='edit')&&($planner_show==0)) ? '' : ' checked' ?> />
                        </div>

                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">ღირსშესანიშნაობა:</div>
                            <input type="checkbox" name="sight_show" class="inp-check"<?php echo (($route[1]=='edit')&&($sight_show==0)) ? '' : ' checked' ?> />
                        </div>

                        <!-- top tours and feachues start -->
                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">ტოპ ტური:</div>
                            <input type="checkbox" name="top_tour" class="inp-check"<?php echo (($route[1]=='edit')&&($top_tour==0)) ? '' : ' checked' ?> />
                        </div>

                        <div class="list2 fix" style="<?=($menuid==47 || $menuid==42) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">ტოპ შეთავაზება:</div>
                            <input type="checkbox" name="top_offers" class="inp-check"<?php echo (($route[1]=='edit')&&($top_offers==0)) ? '' : ' checked' ?> />
                        </div>
                        <!-- top tours and feachues end -->


                        <div class="list2 fix" style="<?=($menuid==47) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">რუკის კორდინატები: <span class="star">*</span></div>                 
                            <input type="text" name="map_coordinates" id ="map_coordinates" value="<?php echo ($subaction=='edit') ? $map_coordinates : '' ?>" class="inp" readonly="readonly" />
                            <div id="map" style="width:100%; height: <?=($menuid!=47) ? '350px' : '0px'?>;"></div>
                            <script>
                                <?php 
                                $ex = (isset($map_coordinates)) ? explode(":", $map_coordinates) : array();
                                $lat = ($subaction=='edit' && isset($ex[0]) && isset($ex[1])) ?  $ex[0] : '41.63514628349129';
                                $lng = ($subaction=='edit' && isset($ex[0]) && isset($ex[1])) ?  $ex[1] : '41.62310082006843';
                                ?>
                                var myLatLng = {lat: <?=$lat?>, lng: <?=$lng?>};
                                $("#map_coordinates").val(myLatLng.lat + ":" + myLatLng.lng);
                                function initMap() {
                                    var map = new google.maps.Map(document.getElementById('map'), {
                                        zoom: 12,
                                        center: myLatLng
                                    });

                                    // Place a draggable marker on the map
                                    var marker = new google.maps.Marker({
                                        position: myLatLng,
                                        map: map,
                                        draggable:true,
                                        title:"Drag me!"
                                    });

                                    // on drag sent info to parent
                                    google.maps.event.addListener(marker, 'dragend', function(e) { 
                                      var lat = marker.getPosition().lat();
                                      var lng = marker.getPosition().lng();

                                      $("#map_coordinates").val(lat + ":" + lng);
                                    });

                                    google.maps.event.addListener(map, 'click', function(e) {
                                        marker.setPosition(e.latLng);
                                        $("#map_coordinates").val(e.latLng.lat() + ":" + e.latLng.lng());
                                    });
                                } 
                            </script>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeSTjMJTVIuJaIiFgxLQgvCRl8HJqo0qo&amp;callback=initMap"></script>
                        </div>

                         <div class="list2 fix" style="<?=($menuid==47) ? 'visibility:hidden; position:absolute' : ''?>">
                            <div class="name">Km price +10:</div>
                            <input type="checkbox" name="price_plus" class="inp-check"<?php echo (($route[1]=='edit')&&(!isset($price_plus) || $price_plus==0)) ? '' : ' checked' ?> />
                        </div>


                    </div>
                    
                    <?php  
                    if(isset($places) && preg_match_all("/\[(\d+)\]/", $places, $matches)){
                        $x = 0;
                        foreach ($matches[1] as $v) {
                            $fetch = g_get_place_by_id($v);
                            echo sprintf(
                                '<input type="hidden" class="hiddenInputPlace hidden%s" name="places[]" value="[%s]" />',
                                $v,
                                $v
                            );
                            $x++;
                        }
                    }
                    ?>

                </form>
            </div>
            <div id="bottom" class="fix">
                <a href="javascript:save('edit');" class="button br"><?php echo a("save");?></a>
                <a href="javascript:save('close');" class="button br"><?php echo a("save&close");?></a>
                <a href="<?php echo ahref(array($route[0], 'show', $menuid));?>" class="button br"><?php echo a("cancel");?></a>
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
        } else if (target.data('tab')) {
            $(target).toggleClass('selbutton');
            $(target).siblings().removeClass('selbutton');
            $('#'+target.data('tab')).show().siblings().hide();
            $('#tab').val(target.data('tab'));
        }
    });

    $(document).on("click", ".addPlace", function(e){
        e.preventDefault();
        var v = $("#places").val();
        if(v==""){ return false; }
        else{            
            // var d = $("#place-day").val();
            // var p = $("#place-price").val();
            var t = $("#places option:selected").text();
            // var elem = '<div class="place-item hidden'+v+'">'+t+' - '+d+' - '+p+' <i data-id="'+v+'">x</i></div>';
            var elem = '<div class="place-item hidden'+v+'">'+t+' <i data-id="'+v+'">x</i></div>';
            // var hidden = '<input type="hidden" name="places[]" class="hiddenInputPlace hidden'+v+'" value="['+v+'-'+d+'-'+p+']" />';
            $('<input>').attr({
                type: 'hidden',
                class: 'hiddenInputPlace hidden'+v,
                name: 'places[]',
                value: '['+v+']'
            }).appendTo('#catform');

            $(".placesbox").append(elem);
            $("#places").val('');
            $("#place-day").val('');
            $("#place-price").val('');
        }        
    });

    $(document).on("click", ".placesbox .place-item i", function(){
        var id = $(this).attr("data-id");
        $(".hidden"+id).remove();
    });

	function save(action) {
        $("#tabstop").val(action);
		var validate = 1;
		var msg = "";
        if($("#pagetitle, #otitle").val()=='') {
            msg = "<?php echo a('error.title');?>";
            validate = 0;
        }
		if(validate == 1) {
            $('#catform').submit();
		} else {
			alert(msg);
		}
	}

    function nextlang(lang) {
        // save(lang);
        var full = window.location.href;
        var repl = full.replace("/<?=l()?>/", "/"+lang+"/");
        location.href = repl;
    }
    function chclick(id, tab) {
        var active = ($('#vis_'+id).val()==0) ? 1 : 0;
        $.post("<?php echo ahref(array($route[0], 'visitem'));?>?visibility=" + active + "&id=" + id + "&tab=" + tab, function(data) {
            if(active==1)
                $('#img_'+id).attr("src","_tripadmin/img/buttons/icon_visible.png");
            else
                $('#img_'+id).attr("src","_tripadmin/img/buttons/icon_unvisible.png");
            $('#vis_'+id).val(active);
        });
    }

    function del(id, title, tab) {
        if (confirm("<?php echo a('deletequestion'); ?>" + title + "?")) {
            $.post("<?php echo ahref(array($route[0], 'delitem'));?>?id=" + id + "&tab=" + tab, function(){
                $("#div" + id).innerHTML = "";
                $("#div" + id).hide();
            });
        }
    }
</script>