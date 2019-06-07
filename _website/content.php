<?php defined('DIR') OR exit();
    if (empty($storage->product)) {
        $section = $storage->section;
    } else {
        $section = $storage->product;
    }
    $section['pid'] = $storage->product['id'];
    $section['id'] = $storage->section['id'];
    empty($section["meta_keys"]) AND $section["meta_keys"] = s('keywords');
    empty($section["meta_desc"]) AND $section["meta_desc"] = s('description');
	$url="";
	$urlparts=array();
	foreach($_GET as $k=>$v) { 
        if($k!='product')
		  $urlparts[]=$k."=".$v;
	}
	if(count($urlparts)>0)
		$url='?'.implode("&",$urlparts);
    $product=NULL;
    if(isset($_GET["product"])) 
        $product=$_GET["product"];

	$photo = "";
	$desc = "";
	$producttitle = "";
	$prod = 0;
	if(isset($_GET["product"])) {
		$prod = $_GET["product"];
		$cat = db_fetch("select * from catalogs where id = '".$_GET["product"]."' and language = '".l()."'");
		$photo = $cat["photo1"];
		$producttitle = $cat["title"];
		$desc = $cat["description"];
		if($desc=="") $desc = $producttitle;
	}
	if($photo=="") $photo = href().WEBSITE."/images/logo.png";
	$pageid = href($storage->section['id']).(($prod>0) ? "?product=".$_GET["product"]:"");

$g_request = new g_requestProtection();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '2094836854180057'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=2094836854180057&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->
    <meta charset="utf-8">
    <?=$g_request->meta_tag()?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    
    <base href="<?php echo href(); ?>" />
	<meta name="theme-color" content="#27774d" />
    <title><?php echo strip_tags(s('sitetitle').' - '.$section["title"]); ?></title>
    <meta name="keywords" content="<?php echo s('keywords').', '.$section["meta_keys"] ?>" />
    <meta name="description" content="<?php echo s('description').', '.$section["meta_desc"] ?>" />
    <meta name="robots" content="index, follow" />
    
    <meta property="og:title" content="<?php echo strip_tags($section["title"]).' - '.s('sitetitle');?>" />
    <meta property="og:image" content="<?php echo (!empty($section["image1"])) ? $section["image1"] : href().WEBSITE."/_website/img/logo.png";?>?v=<?=WEBSITE_VERSION?>" />
    <meta property="og:description" content="<?php echo $section["meta_desc"] ?>"/>
    <meta property="og:url" content="<?php echo href($storage->section['id'], array(), '', $section["pid"]);?>" />
    <meta property="og:site_name" content="<?php echo s('sitetitle'); ?>" />
    <meta property="og:type" content="Website" />

	<link rel="shortcut icon" href="_website/img/favicon.png?v=<?=WEBSITE_VERSION?>">

	<script src="_website/js/compressed.js?v=<?=WEBSITE_VERSION?>"></script>
	<script src="_website/js/slick.min.js?v=" type="text/javascript"></script>
	<link rel="stylesheet" href="_website/css/compressed.css?v=<?=WEBSITE_VERSION?>">
	<?php if(l()=='ge'){ ?>
	<link rel="stylesheet" href="_website/css/geo.css?v=<?=WEBSITE_VERSION?>">
	<?php } else if(l()=='ru') { ?>
	<link rel="stylesheet" href="_website/css/rus.css?v=<?=WEBSITE_VERSION?>">
	<?php } ?>


<script type="text/javascript">
$.fn.datepicker.dates.<?=l()?> = {
	days: [
		"<?=$c['day.names'][1][l()]?>", 
		"<?=$c['day.names'][2][l()]?>", 
		"<?=$c['day.names'][3][l()]?>",
		"<?=$c['day.names'][4][l()]?>", 
		"<?=$c['day.names'][5][l()]?>",
		"<?=$c['day.names'][6][l()]?>",
		"<?=$c['day.names'][7][l()]?>"
	],
	daysShort: [
		"<?=$c['day.shortnames'][1][l()]?>", 
		"<?=$c['day.shortnames'][2][l()]?>", 
		"<?=$c['day.shortnames'][3][l()]?>",
		"<?=$c['day.shortnames'][4][l()]?>", 
		"<?=$c['day.shortnames'][5][l()]?>",
		"<?=$c['day.shortnames'][6][l()]?>",
		"<?=$c['day.shortnames'][7][l()]?>"
	],
	daysMin: [
		"<?=$c['day.shortnames'][1][l()]?>", 
		"<?=$c['day.shortnames'][2][l()]?>", 
		"<?=$c['day.shortnames'][3][l()]?>",
		"<?=$c['day.shortnames'][4][l()]?>", 
		"<?=$c['day.shortnames'][5][l()]?>",
		"<?=$c['day.shortnames'][6][l()]?>",
		"<?=$c['day.shortnames'][7][l()]?>"
	],
	months: [
		"<?=$c['month.names'][1][l()]?>", 
		"<?=$c['month.names'][2][l()]?>", 
		"<?=$c['month.names'][3][l()]?>",
		"<?=$c['month.names'][4][l()]?>", 
		"<?=$c['month.names'][5][l()]?>",
		"<?=$c['month.names'][6][l()]?>",
		"<?=$c['month.names'][7][l()]?>",
		"<?=$c['month.names'][8][l()]?>",
		"<?=$c['month.names'][9][l()]?>",
		"<?=$c['month.names'][10][l()]?>",
		"<?=$c['month.names'][11][l()]?>",
		"<?=$c['month.names'][12][l()]?>"
	],
	monthsShort: [
		"<?=$c['month.shortnames'][1][l()]?>", 
		"<?=$c['month.shortnames'][2][l()]?>", 
		"<?=$c['month.shortnames'][3][l()]?>",
		"<?=$c['month.shortnames'][4][l()]?>", 
		"<?=$c['month.shortnames'][5][l()]?>",
		"<?=$c['month.shortnames'][6][l()]?>",
		"<?=$c['month.shortnames'][7][l()]?>",
		"<?=$c['month.shortnames'][8][l()]?>",
		"<?=$c['month.shortnames'][9][l()]?>",
		"<?=$c['month.shortnames'][10][l()]?>",
		"<?=$c['month.shortnames'][11][l()]?>",
		"<?=$c['month.shortnames'][12][l()]?>",
	],
	today: "<?=$c['today'][l()]?>"
};
</script>

<!-- MailerLite Universal -->
<script>
(function(m,a,i,l,e,r){ m['MailerLiteObject']=e;function f(){
var c={ a:arguments,q:[]};var r=this.push(c);return "number"!=typeof r?r:f.bind(c.q);}
f.q=f.q||[];m[e]=m[e]||f.bind(f.q);m[e].q=m[e].q||f.q;r=a.createElement(i);
var _=a.getElementsByTagName(i)[0];r.async=1;r.src=l+'?v'+(~~(new Date().getTime()/1000000));
_.parentNode.insertBefore(r,_);})(window, document, 'script', 'https://static.mailerlite.com/js/universal.js', 'ml');

var ml_account = ml('accounts', '1240842', 'l3m8y1l7t3', 'load');
</script>
<!-- End MailerLite Universal -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-136984499-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-136984499-1');
</script>


</head>
<body>
<div id="preloader"></div>
<?php 
$g_gift = g_gift();
if($g_gift["menutitle"]==1):
?>
<div class="modal fade TripModalStyle giftpopup" id="giftpopup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-body" style="background-color: transparent !important;">
        		<div class="popupStyle" style="background-image: url('<?=$g_gift["image1"]?>');"></div>
            </div> 
        </div>
    </div>
</div>
<div class="gift" onclick="$('#giftpopup').modal('show')"></div>
<?php endif; ?>

<div class="newScroller">
	<span></span>
	<!-- <span></span>
	<span></span> -->
</div>
<script>
	document.getElementsByClassName("newScroller")[0].addEventListener("click", () => {
	var elmnt = document.getElementsByClassName("ToursListDiv")[0];
	elmnt.scrollIntoView();
});
</script>

<!-- Messages Popups -->
<div class="modal fade MessagesPopup" id="ErrorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-body">
        		<div class="CloseButton" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
                <div class="Title"><?=l("wrongmessage")?></div>
                <div class="Text">...</div>
            </div> 
        </div>
    </div>
</div>
<!-- map popup -->
<div class="modal fade TripModalStyle" id="HomeMapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">        
			<div class="modal-body" id="modal_body">
                
            </div> 
		</div>
    </div>
</div>

<div class="modal fade MessagesPopup" id="SuccessModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-body">
        		<div class="CloseButton" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
                <div class="Title"><?=l("successmessage")?></div>
                <div class="Text">...</div>
            </div> 
        </div>
    </div>
</div>
<div class="modal fade MessagesPopup" id="PromptModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-body">
        		<div class="CloseButton" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
                <div class="Title">Need Hotel?</div>
                <div class="Icon"><img src="_website/img/hotel_icon.png"/></div>
                <div class="ButtonsModal">
                	<div class="col-sm-6">
                		<button class="GreenButton">Yes</button> 
                	</div>
                	<div class="col-sm-6"> 
                		<button class="GrayButton">No</button>
                	</div>
                </div>
            </div> 
        </div>
    </div>
</div>

<!-- InsuarancePopupBox Popups -->
<div class="modal fade InsuarancePopupBox" id="InsuarancePopupBox" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-body">
        		<div class="CloseButton" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
                <div class="Title" style="margin: 20px 0 40px 0; font-size:19px; font-family: bpg_nino_mtavruli_normal"><?=l("freeinsurance")?></div>
                
            	<div class="form-group col-sm-12 g-insuarance-error" style="display: none;">
                	<p><?=l("allfields")?></p>
				</div>

            	<div class="form-group col-sm-6">
                	<div class="MaterialForm">						
						<input type="text" class="g-insuarance-damzgvevi" />
						<span class="highlight"></span>
						<span class="bar"></span>
						<label><?=l("damzgvevi")?></label>
					</div>
				</div>
				<div class="form-group col-sm-6">
                	<div class="MaterialForm">
						<input type="text" class="g-insuarance-dazgveuli" />
						<span class="highlight"></span>
						<span class="bar"></span>
						<label><?=l("dazgveuli")?></label>
					</div>
				</div>
				<div class="form-group col-sm-6">
                	<div class="MaterialForm">
						<input type="text" class="g-insuarance-misamarti" />
						<span class="highlight"></span>
						<span class="bar"></span>
						<label><?=l("address")?></label>
					</div>
				</div>
				<div class="form-group col-sm-6">
                	<div class="MaterialForm">
						<input type="text" class="g-insuarance-dabtarigi" />
						<span class="highlight"></span>
						<span class="bar"></span>
						<label><?=l("dob")?></label>
					</div>
				</div>
				<div class="form-group col-sm-6">
                	<div class="MaterialForm">
						<input type="text" class="g-insuarance-pasporti" />
						<span class="highlight"></span>
						<span class="bar"></span>
						<label><?=l("pasportisnomeri")?></label>
					</div>
				</div>
				<div class="form-group col-sm-6">
                	<div class="MaterialForm">
						<input type="text" class="g-insuarance-piradinomeri" />
						<span class="highlight"></span>
						<span class="bar"></span>
						<label><?=l("piradinomeri")?></label>
					</div>
				</div>
				<div class="form-group col-sm-6">
                	<div class="MaterialForm">
						<input type="text" class="g-insuarance-telefonis" />
						<span class="highlight"></span>
						<span class="bar"></span>
						<label><?=l("telefonisnomeri")?></label>
					</div>
				</div>
				<div class="form-group col-sm-12">
					<div class="MaterialForm">
						 <button class="GreenCircleButton_4 g-insurance-save-button"><?=l("save")?></button>
					</div>					
				</div>
				<div style="clear: both;"></div>

				
            </div> 
        </div>
    </div>
</div>

<div class="BookNowRightDiv">
	<form action="javascript:void(0)" method="post">
		<input type="hidden" name="CSRF_token" value="<?=$_SESSION["CSRF_token"]?>" />
		<div class="BookNowButton"><?=l("contact")?></div>
		<div class="Title"><?=l("contact")?></div>
		<div class="form-group col-sm-6">
			<div class="MaterialForm contact-firstname-box">
				<input type="text" class="contact-firstname" name="contact-firstname" value="">
				<span class="highlight"></span>
				<span class="bar"></span>
				<label><?=l("firstname")?></label>
				<div class="ErrorText gErrorText"></div>
			</div>					
		</div>
		<div class="form-group col-sm-6">
			<div class="MaterialForm contact-lastname-box">
				<input type="text" class="contact-lastname" name="contact-lastname" value="">
				<span class="highlight"></span>
				<span class="bar"></span>
				<label><?=l("lastname")?></label>
				<div class="ErrorText gErrorText"></div>
			</div>					
		</div>
		<div class="form-group col-sm-12">
			<div class="MaterialForm contact-email-box">
				<input type="text" class="contact-email" name="contact-email" value="">
				<span class="highlight"></span>
				<span class="bar"></span>
				<label><?=l("email")?></label>
				<div class="ErrorText gErrorText"></div>
			</div>					
		</div>
		<div class="form-group col-sm-12">
			<div class="MaterialForm contact-mobile-box">
				<input type="number" class="contact-mobile" name="contact-mobile" value="" style="width: 100%; padding: 15px 10px 11px 0px;">
				<span class="highlight"></span>
				<span class="bar"></span>
				<label><?=l("mobile")?></label>
				<div class="ErrorText gErrorText"></div>
			</div>					
		</div>
		<div class="form-group col-sm-12">
			<div class="MaterialForm contact-comment-box">
				<input type="text" class="contact-comment" name="contact-comment" value="">
				<span class="highlight"></span>
				<span class="bar"></span>
				<label><?=l("comment")?></label>
				<div class="ErrorText gErrorText"></div>
			</div>					
		</div>
		<div class="form-group col-sm-6">
			<div class="MaterialForm">
				 <button class="GreenCircleButton_4 contact-send-button"><?=l("send")?></button>
			</div>					
		</div>
	</form>
</div>

<?php 
/* search start */
?>
<div class="modal fade TripModalStyle" id="SearchModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-body">
                <div class="SearchModalContent">

                	<div class="ModalSearchInputs">
                		<div class="form-group col-sm-12 padding_0">
							<div class="MaterialForm">
								<input type="text" value="" id="g-search-input" />
								<span class="highlight"></span>
								<span class="bar"></span>
								<label><?=l('search')?></label>
								<button class="SearchButton"></button>
							</div>					
						</div>
                	</div>
                	<div class="row">
                		<div class="col-sm-9">
                			<div class="ModalSearchItems">
		                		 <li><?=menu_title(63)?> <span id="g-search-count-tours">0</li>
		                		 <li><?=menu_title(86)?> <span id="g-search-count-blog">0</span></li>
		                		 <li><?=menu_title(110)?> <span id="g-search-count-places">0</span></li>
		                	</div>
                		</div>
                		<div class="col-sm-3 text-right">
                			<div class="SearchResultText"><?=l('searchresult')?>: <span id="g-search-count-result">0</span></div>
                		</div>
                	</div>
                	<div class="ToursList">
						<div class="row" id="g-search-result">				
							<!--  -->
						</div>
					</div>
                </div>
            </div> 
        </div>
    </div>
</div>
<?php 
/* search end */
?>







<div class="MobileMenuDiv ">
	<div class="MenuList">
		<li><a href="<?php echo href('1');?>"><?php echo menu_title('1');?></a></li>
		<li><a href="<?php echo href('64');?>"><?php echo menu_title('64');?></a></li>
		<li><a href="<?php echo href('86');?>"><?php echo menu_title('86');?></a></li>
		<li><a href="<?php echo href('124');?>"><?php echo menu_title('124');?></a></li>
		<li><a href="<?php echo href('61');?>"><?php echo menu_title('61');?></a></li>
		<li><a href="<?php echo href('62');?>"><?php echo menu_title('62');?></a></li>
		<li><a href="<?php echo href('63');?>"><?php echo menu_title('63');?></a></li>
	</div>
	
	<div class="SelectsMenuDiv">
		<div class="col-sm-12">
			<div class="MenuSelect">
				<i class="fa fa-chevron-down"></i>
				<?php 
				$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$en = str_replace("/".l()."/", "/en/", $actual_link); 
				$ge = str_replace("/".l()."/", "/ge/", $actual_link);
				$ru = str_replace("/".l()."/", "/ru/", $actual_link)
				?>
				<select onchange="location = this.value;">
					<option value="<?php echo htmlentities($en); ?>" <?=(l()=="en") ? 'selected="selected"' : ''?>>ENG</option>
					<option value="<?php echo htmlentities($ge); ?>" <?=(l()=="ge") ? 'selected="selected"' : ''?>>GEO</option>
					<option value="<?php echo htmlentities($ru); ?>" <?=(l()=="ru") ? 'selected="selected"' : ''?>>RUS</option>
				</select>
			</div>
		</div>

		<div class="col-sm-12">
			<?php 
			$currency = (isset($_SESSION["currency"])) ? $_SESSION["currency"] : 'gel';
			?>
			<div class="MenuSelect" style="margin-top: 15px;">
				<i class="fa fa-chevron-down"></i>
				<select onchange="$('.cur-aj-'+this.value).click()">
					<option value="gel" <?=($currency=="gel") ? 'selected="selected"' : ''?>>GEL</option>
					<option value="usd" <?=($currency=="usd") ? 'selected="selected"' : ''?>>USD</option>
					<option value="eur" <?=($currency=="eur") ? 'selected="selected"' : ''?>>EUR</option>
				</select>
			</div>
		</div>
	</div>
	
</div>






<div style="float: left; width: 100%;">
	<div class="HeaderDiv">
		<a href="javascript:void(0)" class="MenuHamburger" style="cursor: pointer;" onclick="openCloseMenuMobile()"></a>
		<div class="container-fluid">
			<div class="col-sm-5 ButtonsColsm5">
				<div class="HeaderButtons" style="display: block;">
					<a href="<?php echo href('61');?>"><span><?php echo menu_title(61);?></span></a>
					<a href="<?php echo href('62');?>"><span><?php echo menu_title(62);?></span></a>
					<a href="<?php echo href('63');?>"><span><?php echo menu_title(63);?></span></a>
				</div>
			</div>
			<div class="col-sm-2 text-center">
				<a href="<?php echo href('1');?>" class="HeaderLogo"></a>
			</div>
			<div class="col-sm-5 text-right">
				<div class="HeaderLoginForm">
					<?=g_usertop()?>
				</div>
				<div class="HeaderSearchIcon" data-toggle="modal" data-target="#SearchModal"></div>
				<a href="<?php echo href('65');?>" class="HeaderCardIcon">
					<?php 
					if(isset($_SESSION["trip_user"])){
				        $userid = $_SESSION["trip_user"];
				    }else{
				        if(isset($_SESSION["cartsession"]))
				        {
				            $userid = $_SESSION["cartsession"];
				        }else{
				            $userid = 0;
				        }
				    }
					?>
					<span><?=g_cart_count($userid)?></span>
				</a>
				<div class="HeaderSelect">
					<input type="hidden" name="input_lang" id="input_lang" value="<?=l()?>" />
					<?php 
					$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					if(l()=='en'){?>            
					<span>Eng</span>
					<div class="SelectDiv">
						<a href="<?php echo (empty($router["slug"])) ? "/ge" : str_replace("/".l()."/", "/ge/", $actual_link); ?>">Geo</a>
						<a href="<?php echo (empty($router["slug"])) ? "/ru" : str_replace("/".l()."/", "/ru/", $actual_link); ?>">Rus</a>
					</div>
					<?php } else if(l()=='ru'){?>                  
					<span>Rus</span>
					<div class="SelectDiv">
						<a href="<?php echo (empty($router["slug"])) ? "/ge" : str_replace("/".l()."/", "/ge/", $actual_link); ?>">Geo</a>
						<a href="<?php echo (empty($router["slug"])) ? "/en" : str_replace("/".l()."/", "/en/", $actual_link); ?>">Eng</a>
					</div>
					<?php } else {?>                  
					<span>Geo</span>
					<div class="SelectDiv">
						<a href="<?php echo (empty($router["slug"])) ? "/en" : str_replace("/".l()."/", "/en/", $actual_link); ?>">Eng</a>
						<a href="<?php echo (empty($router["slug"])) ? "/ru" : str_replace("/".l()."/", "/ru/", $actual_link); ?>">Rus</a>
					</div>                                
					<?php } ?>			
	            </div>

	            <?php 
					$cur = "<i>A</i>"; //TripCheckbox
					$cur_exchange = 1;
					$cur_exchange_usd = (float)s("currencyusd");
					$cur_exchange_eur = (float)s("courseeur");
					if(isset($_SESSION["currency"])){
						if($_SESSION["currency"]=="usd"){
							$cur = "$";
							$cur_exchange = (float)s("currencyusd");						
						}

						if($_SESSION["currency"]=="eur"){
							$cur = "&euro;";
							$cur_exchange = (float)s("courseeur");						
						}
					}
					?>
					<input type="hidden" name="g-cur" id="g-cur" value="<?=htmlentities($cur)?>" />
					<input type="hidden" name="g-cur-exchange" id="g-cur-exchange" value="<?=$cur_exchange?>" />
					<input type="hidden" name="g-cur-exchange-usd" id="g-cur-exchange-usd" value="<?=$cur_exchange_usd?>" />
					<input type="hidden" name="g-cur-exchange-eur" id="g-cur-exchange-eur" value="<?=$cur_exchange_eur?>" />

				<div class="HeaderSelect currencyBox">
					<input type="hidden" name="g-cur__" id="g-cur__" value="<?=(!isset($_SESSION["currency"])) ? 'gel' : $_SESSION["currency"]?>" />
					<span class="g-aj-currency" style="text-transform: uppercase;">
						<?=(!isset($_SESSION["currency"])) ? 'gel' : $_SESSION["currency"]?>
					</span>
					<div class="SelectDiv">
						<?php 
						$curr = array("gel", "usd", "eur"); 
						foreach ($curr as $v):
							$style = "";
							if( (isset($_SESSION["currency"]) && $_SESSION["currency"]==$v) || (!isset($_SESSION["currency"]) && $v=="gel") ){
								$style = " style=\"display:none\"";
							}
						?>
						<a href="javascript:void(0);" class="changeCurrency cur-aj-<?=$v?>" data-cur="<?=$v?>"<?=$style?>><?=$v?></a>
						<?php endforeach; ?>
					</div>
				</div>
				 
			</div>
		</div>
	</div>
</div>

<?php echo html_decode($storage->content); ?>

<div class="FooterDiv">
	<div class="container">
		<div class="row"> 
			<div class="col-sm-8 padding_0">
				<div class="col-sm-3">
					<a href="#" class="FooterLogo"></a>
					<div class="FooterSmallText">
						<!-- We create possibilities for the connected world. -->
						<?=l("footertext")?>
					</div>					
				</div>
				<div class="col-sm-3">
					<div class="FooterMenu">
						<div class="Title"><?=l("abouttripplanner")?></div>
						<li><a href="/<?=l()?>/about-us"><?=menu_title(64)?></a></li>
						<li><a href="/<?=l()?>/why-us"><?=menu_title(124)?></a></li>
						<li><a href="/<?=l()?>/blog"><?=menu_title(86)?></a></li>
						<li><a href="/<?=l()?>/faq"><?=menu_title(194)?></a></li>
						<li><a href="/<?=l()?>/contact"><?=menu_title(176)?></a></li>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="FooterMenu">
						<div class="Title"><?=l("productexplore")?></div>
						<li><a href="/<?=l()?>/plan-your-trip"><?=menu_title(61)?></a></li>
						<li><a href="/<?=l()?>/transfers"><?=menu_title(62)?></a></li>
						<li><a href="/<?=l()?>/ongoing-tours"><?=menu_title(63)?></a></li>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="FooterMenu">
						<div class="Title">&nbsp;</div>
						<li><a href="<?=s("tripfacebook")?>" target="_blank">Facebook</a></li>
						<li><a href="<?=s("tripinstagram")?>" target="_blank">Instagram</a></li>

						<div id="TA_socialButtonReviews274" class="TA_socialButtonReviews"><ul id="DNK2k0dDd9L2" class="TA_links w01WytDZi1yb" style="line-height: 10px;"><li id="JjqwNwNdEr" class="VkN5INcA"><a target="_blank" href="https://www.tripadvisor.com/Attraction_Review-g294195-d16851730-Reviews-Tripplanner_ge-Tbilisi.html"><img src="https://www.tripadvisor.com/img/cdsi/img2/branding/socialWidget/20x28_green-21692-2.png"/></a></li></ul></div><script async src="https://www.jscache.com/wejs?wtype=socialButtonReviews&amp;uniq=274&amp;locationId=16851730&amp;color=green&amp;size=rect&amp;lang=en_US&amp;display_version=2" data-loadtrk onload="this.loadtrk=true"></script>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="NewsLetterForm">
					<div class="FooterMenu">
						<div class="Title"><?=l("newsletter")?></div> 
					</div>	

					<div class="ml-form-embed"
					data-account="1240842:l3m8y1l7t3"
					data-form="1020702:z4c7w9">
					</div>
				</div>
				<div class="FooterContactInfo">
					<!-- <li><?=s("Address")?></li> -->
					<li><?=s('Email')?></li>
					<li><?=s('phone');?></li>
				</div>	
				<div class="FooterSocialResponsive"> 
					<li><a href="<?=s("tripfacebook")?>" target="_blank">Facebook</a></li>
					<li><a href="<?=s("tripinstagram")?>" target="_blank">Instagram</a></li>
				</div>
				
			</div>
			
			<div class="col-sm-12 ">
				<div class="CopyRight">
					© 2017 Tripplanner. All Rights Reserved.
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('#image_map').css('height',$(window).height()-260);
	$('.header').height($(window).height());
	$(window).resize(function(){
		$('#image_map').css('height',$(window).height()-260);
		$('.header').height($(window).height());
	});
	$('#slide_down').click(function(e){
		$('body').animate({scrollTop:$(window).height()}, '500', 'swing', function() { });
	})


	AmCharts.mapTranslations.ka = {
		"Abkhazeti":"<?=menu_title(101)?>",
		"Adjara":"<?=menu_title(94)?>",
		"Samegrelo - Zemo Svaneti":"<?=menu_title(92)?>",
		"Guria":"<?=menu_title(100)?>",
		"Imereti":"<?=menu_title(90)?>",
		"Racha-Lechkhumi & Kvemo Svaneti":"<?=menu_title(98)?>",
		"Samtskhe-Javakheti":"<?=menu_title(93)?>",
		"Qvemo Kartli":"<?=menu_title(97)?>",
		"Mtskheta-Mtianeti":"<?=menu_title(95)?>",
		"Shida Kartli":"<?=menu_title(96)?>",
		"Tbilisi":"<?=menu_title(99)?>",
		"Kakheti":"<?=menu_title(91)?>"
	};

	var ammap = AmCharts.makeChart("image_map",{
		"type": "map",
		"pathToImages": "http://www.amcharts.com/lib/3/images/",
		"addClassNames": true,
		"fontSize": 15,
		"language":"ka",
		"color": "#FFFFFF",
		"projection": "mercator",
		"backgroundAlpha": 1,
		"backgroundColor": "rgba(241,249,245,0)",
		"dataProvider": {
			"map": "georgiaLow",
			"getAreasFromMap": true,
			"images": [
				{
					"top": 40,
					"left": 60,
					"width": 80,
					"height": 40,
					"pixelMapperLogo": false,
					"imageURL": "",
					"url": ""
				}
			]
		},
		"balloon": {
			"horizontalPadding": 15,
			"borderAlpha": 0,
			"borderThickness": 1,
			"verticalPadding": 15
		},
		"areasSettings": {
			"color": "rgba(32,128,97,1)",
			"outlineColor": "rgba(39,153,113,1)",
			"rollOverOutlineColor": "rgba(39,153,113,1)",
			"rollOverColor": "rgba(188,158,62,1)",
			"rollOverBrightness": 20,
			"selectedBrightness": 20,
			"selectable": true,
			"unlistedAreasAlpha": 0,
			"unlistedAreasOutlineAlpha": 0
		},
		"imagesSettings": {
			"alpha": 1,
			"color": "rgba(129,129,129,1)",
			"outlineAlpha": 0,
			"rollOverOutlineAlpha": 0,
			"outlineColor": "rgba(80,80,80,1)",
			"rollOverBrightness": 20,
			"selectedBrightness": 20,
			"selectable": false
		},
		"linesSettings": {
			"color": "rgba(129,129,129,1)",
			"selectable": true,
			"rollOverBrightness": 20,
			"selectedBrightness": 20
		},
		"zoomControl": {
			"zoomControlEnabled": false,
			"homeButtonEnabled": false,
			"panControlEnabled": false,
			"right": 38,
			"bottom": 30,
			"minZoomLevel": 0.25,
			"gridHeight": 100,
			"gridAlpha": 0.1,
			"gridBackgroundAlpha": 0,
			"gridColor": "#FFFFFF",
			"draggerAlpha": 1,
			"buttonCornerRadius": 2
		},
		"listeners": [{
		    "event": "rendered",
		    "method": function(e) {
		     	$('[aria-label=" Qvemo Kartli  "]').attr("aria-label", "<?=menu_title(97)?>");
		    }
		 }]
	});

	ammap.dragMap = false;
	

	ammap.addListener("clickMapObject", function (event) {
		console.log(event.mapObject);
		$('.InfoHeader .Title').html(event.mapObject.enTitle);
		$('#modal_body').html(
				'<div align="center"> <img src="/public/images/ripple.gif"> </div>');
		var input_lang = $("#input_lang").val();
		var map_id = event.mapObject.id;


		$.ajax({
	        type: "POST",
	        url: "/"+input_lang+"/?ajax=true",
	        data: { 
	            type:"mapClicked", 
	            input_lang:input_lang, 
	            map_id:map_id                
	        } 
	    }).done(function( msg ) {
	        var obj = $.parseJSON(msg);
	        if(obj.Error.Code==1){            
	             console.log(obj.Error.Text);
	        }else{
	            $('#modal_body').html(obj.Success.Html);
	            $("#HomeMapModal").modal();
	        }
	    });
		
	});




});

$(document).ready(function(){
	$(".PageTitle").children().each(function () {
	    $(this).html( $(this).html().replace(/\?/g,"<i style='font-family:DejaVuSans; font-style:normal'>?</i>") );
	});
});

</script> 

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/58c9081478d62074c0a1dfb8/default';
s1.charset='UTF-8';
s1.language='ka';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();

$(document).ready(function(){
	<?php 
	if(!isset($_SESSION["Tawk_API"])):
	?>
		setTimeout(function(){
			if(
				!Tawk_API.isChatMaximized() && 
				!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
			){
				Tawk_API.toggle();
			}
		}, 3900);
	<?php endif; 
	$_SESSION["Tawk_API"] = true;
	?>
});
</script>
<!--End of Tawk.to Script-->

</body>
</html>