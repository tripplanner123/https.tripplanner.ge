<?php
defined('DIR') OR exit;

$idx = 0;
$num = count($answers);

if(isset($_GET["vote_form_perform"])) {
	$ip = get_ip() . '-' . $_SERVER['REMOTE_ADDR'];
	foreach ($answers AS $item):
		$pollid=$item["pollid"];
	endforeach;
	$ippresent=db_fetch("select count(*) as cnt from pollips where votedate='".date("Y-m-d")."' and ip='".$ip."' and pollid='".$pollid."' ");
	if($ippresent["cnt"]==0) {
		db_query("insert into pollips (votedate, ip, pollid) values('".date("Y-m-d")."','".$ip."','".$pollid."')");
		db_query("update pollanswers set answercounttotal=answercounttotal+1 where id='".$_GET["poll"]."'");
		db_query("update pollanswers set answercount=answercount+1 where id='".$_GET["poll"]."' and language='".l()."'");
	}
}

?>
    <div class="block br fix">
        <ul class="menu">
            <li></li>					
		</ul>
		<div class="white fix">
            <div class="part">
                <div class="list fix" style="border:none">
                    <div class="item-info">
                        <div class="news-name cufon"><?php echo $title; ?></div>	
                    </div>	
                </div>
			</div>
<?php
$idx = 0;
$total = 0;
$max = 0;
foreach ($answers AS $item):
	if($item["answercounttotal"]>$max) $max = $item["answercounttotal"];
	$total = $total + $item["answercounttotal"];
endforeach;
if($max==0) $max=1;
?>
            <form action="<?php echo href($id, array(), l());?>">
            <div style="float:left">
<?php
$n=0;
foreach ($answers AS $item):
	$n=$n+1;
//	$total = $total + $item["answercounttotal"];
?>
                <div class="part" style="border:none; height:24px; margin:0; paddiing:0;">
                    <div class="list fix" style="border:none; height:24px; margin:0; paddiing:0;">
                        <div style="float:left; width:250px;"><input type="radio" name="poll" value="<?php echo $item['id'];?>" <?php echo(($n==1) ? ' checked ':'');?>> <?php echo $item['answer']; ?></div>
                        <div style="float:left; width:400px;">
<?php
	if($item["answercounttotal"]>0){
?>
									<div style="padding-left:5px; padding-top:7px; margin-top:-7px; height:20px; background-color:#1478B5; color:#fff; width:<?php echo intval(($item["answercounttotal"] * 400) / $max)?>px;"><?php echo $item["answercounttotal"];?> </div>
<?php
	} else {
?>                                	
									<div style="padding-left:5px; padding-top:7px; margin-top:-7px; height:20px;"><?php echo $item["answercounttotal"];?> </div>
<?php
	}
?>                                	
                        </div>
                    </div>
                </div>
	            <div class="clear"></div>
<?php
endforeach;
?>
                <div class="part">
                    <div class="list fix" style="border:none">
						<input type="submit" name="vote_form_perform" value="<?php echo ((l()=='ge') ? 'ხმის მიცემა' : 'Vote');?>" style="font-size:10px; height:20px;" />
                    </div>
                </div>
	            <div class="clear"></div>
                <div class="part">
                    <div class="list fix" style="border:none">
						<?php echo ((l()=='ge') ? 'სულ ხმების რაოდენობა' : 'Total Votes'); echo ':' . $total;?>
                    </div>
                </div>
	            <div class="clear"></div>
            </div>
			</form>
        </div>
    </div>


