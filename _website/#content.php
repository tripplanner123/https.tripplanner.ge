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

  if(isset($_POST['login'])){
    $email = trim(db_escape($_POST['email']));
    $pass = sha1(md5(trim(db_escape($_POST['password']))));
    $result = db_fetch("SELECT * FROM site_users WHERE email='".$email."' and password='".$pass."' and active=1 ");
    if(!empty($result)) {
      $_SESSION["user"] = $result;
        db_query("update cart set uid=".$result["id"]." where session='".session_id()."'");
          redirect(href($storage->section["id"]));
        } 
    if($pass != $result["userpass"]) {
      $passworderror = 1;
    }
  }

  if(isset($_GET["logout"])) {
    unset($_SESSION["user"]);
    redirect(href(7));
  }
?>
<!DOCTYPE html>
<head>
    <base href="<?php echo href(); ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo strip_tags(s('sitetitle').' - '.$section["title"]); ?></title>
    <meta name="keywords" content="<?php echo s('keywords').', '.$section["meta_keys"] ?>" />
    <meta name="description" content="<?php echo s('description').', '.$section["meta_desc"] ?>" />
    <meta name="robots" content="index, follow" />
    <meta property="og:title" content="<?php echo strip_tags($section["title"]).' - '.s('sitetitle');?>" />
    <meta property="og:image" content="<?php echo (!empty($section["image1"])) ? $section["image1"] : href().WEBSITE."/images/logo.png";?>" />
    <meta property="og:description" content="<?php echo $section["meta_desc"] ?>"/>
    <meta property="og:url" content="<?php echo href($storage->section['id'], array(), '', $section["pid"]);?>" />
    <meta property="og:site_name" content="<?php echo s('sitetitle'); ?>" />
    <meta property="og:type" content="Website" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link type="image/x-icon" rel="shortcut icon" href="<?php echo WEBSITE ?>/images/favicon.ico" />

    <!-- Bootstrap Font-awesome CSS START -->
    <link type="text/css" media="all" rel="stylesheet" href="<?php echo WEBSITE ?>/css/bootstrap/bootstrap-select.css" />
    <link type="text/css" media="all" rel="stylesheet" href="<?php echo WEBSITE ?>/css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo WEBSITE ?>/css/custom/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap Font-awesome CSS END -->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300italic,400italic,700,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Fonts CSS END -->

    <link type="text/css" media="all" rel="stylesheet" href="<?php echo WEBSITE ?>/css/main.css" />
    <link type="text/css" media="all" rel="stylesheet" href="<?php echo WEBSITE ?>/css/de.css" />

    <link rel="stylesheet" href="<?php echo JAVASCRIPT ?>/fancybox/css/jquery.fancybox.css">

    <script src="<?php echo JAVASCRIPT ?>/jquery/jquery.min.js"></script>
    <script src="<?php echo JAVASCRIPT ?>/fancybox/jquery.fancybox.js"></script>

    
</head>
<body>
<div id="full-content">
  <div id="wrapper-outerheight">
    <div id="header">
      <div class="container">
        <div id="header-left" class="clearfix">
          <div id="rm"></div>
                <a href="<?php echo href(1);?>" id="logo"></a>
          <div id="menu" class="menu">
            <div id="rmh" style="height: 71px;">
              <div class="text">menu</div>
            </div>
            <ul class="clearfix">
              <?php echo main_menu();?>
            </ul>
          </div>
        </div>
        <div id="header-right" class="clearfix">
          <div id="lang">
            <ul>
              <li>
                <a href="<?php echo href($section['id'], array(), l(), $section['pid']) ?>">
                  <span class="text"><?php echo l();?></span>
                  <span class="icon">
                    <img src="_website/images/<?php echo l();?>.png" width="22" height="16" alt="">
                  </span>
                </a>
                <ul style="padding: 0;">
                  <?php 
                    $lang = c('languages.all');
                    for($i=0; $i<count($lang); $i++){
                      if($lang[$i] != l()){
                  ?>
                    <li>
                      <a href="<?php echo href($section['id'], array(), $lang[$i], $section['pid']) ?>" style="white-space:nowrap;">
                        <span class="text"><?php echo $lang[$i];?></span>
                        <span class="icon"><img src="_website/images/<?php echo $lang[$i];?>.png" width="22" height="16" alt=""></span>
                      </a>
                    </li>
                  <?php 
                      } 
                    } 
                  ?>
                </ul>
              </li>
            </ul>
          </div>
          <a href="<?php echo href(16);?>" id="cart-amount"><span class="count">(<?php echo basket_cnt()?>)</span></a>
        </div>
      </div>
    </div>
    <!-- header end -->
    <div id="content">
      <div id="search">
        <div class="container">
          <form action="<?php echo href(22);?>" method="get">
            <div class="input-group">
              <div class="input-group-btn">
                  <?php echo searchCatalog($section['id']);?>
              </div><!-- /btn-group -->
              <input type="text" class="form-control" name="cat-search" value="<?php echo ((isset($_GET['cat-search'])) ? $_GET['cat-search'] : '') ?>" onkeyup="javascript:showSearchBox();" id="srch" autocomplete="off">
                <div class="searchbox" id="searchbox" style="position:absolute; display:none; padding-top:50px; width:1012px;z-index:10">test</div>
              <span class="input-group-btn"><button class="btn search-btn" type="submit"><div class="fa fa-search fa-lg"></div></button></span>
            </div><!-- /input-group -->
          </form>
        </div>
      </div>

      <?php echo html_decode($storage->content); ?>

    </div>
    <!-- content end -->
  </div>
  <div id="footer">
    <div class="container">
      <div class="row">

        <?php echo pages(2);?>

        <div class="list col-md-3">
          <div class="title">
            <h3><?php echo l('contact');?></h3>
          </div>
          <ul class="info">
            <li>
              <span class="lab"><?php echo l('phone');?>:</span>
              <span class="val"><?php echo s('phone');?></span>
            </li>
            <li>
              <span class="lab"><?php echo l('address');?>:</span>
              <span class="val"><?php echo s('address');?></span>
            </li>
            <li>
              <span class="lab"><?php echo l('email');?>:</span>
              <span class="val"><?php echo s('mail');?></span>
            </li>
          </ul>
        </div>
        <div class="col-md-3">
          <ul class="socials list-inline">
            <?php if(s('fblink')!=''){ ?>
            <li>
              <a href="<?php echo s('fblink');?>" class="soc">
                <div class="fa fa-facebook fa-lg"></div>
              </a>
            </li>
            <?php } ?>
            <?php if(s('twlink')!=''){ ?>
            <li>
              <a href="<?php echo s('twlink');?>" class="soc">
                <div class="fa fa-twitter fa-lg"></div>
              </a>
            </li>
            <?php } ?>
            <?php if(s('inlink')!=''){ ?>
            <li>
              <a href="<?php echo s('inlink');?>" class="soc">
                <div class="fa fa-linkedin fa-lg"></div>
              </a>
            </li>
            <?php } ?>
          </ul>
          <div id="copy">
            <?php echo s('copy');?>
          </div>
          <div id="created">
            <a href="http://digitaldesign.ge/" target="_blanck">
              <img src="_website/images/created.png" alt="">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- footer end -->
</div>


<!-- JS -->
<!-- // JS Default scripts -->
<script src="<?php echo JAVASCRIPT ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo JAVASCRIPT ?>/bootstrap/js/bootstrap-select.js"></script>
<!-- // JS My Custom scripts -->
<script src="<?php echo JAVASCRIPT ?>/custom/custom.js"></script>
 
<script type="text/javascript">
  $(document).ready(function() {
    $(".various").fancybox({
      maxWidth  : 800,
      maxHeight : 600,
      fitToView : false,
      width   : '70%',
      height    : '70%',
      autoSize  : false,
      closeClick  : false,
      openEffect  : 'elastic',
      closeEffect : 'none'
    });
  });

  $(document).ready(function() {
    $(".fancybox").fancybox();
  });

 $(document).ready(function(){
       jQuery(document).click(function(){
   $("#searchbox").hide();
        });            
    });
 function showSearchBox() {
  var t = $("#srch").val(); 
  if(t.length>6) {
   $.post("<?php echo href(21);?>?ajax=1&word=" + t, function( data ) {
      $("#searchbox").html( data );
      if(data.length>0)
     $("#searchbox").show();
    else
     $("#searchbox").hide();
   });
  } else {
   $("#searchbox").hide();
  };
 }
 function s(){
 $('#searchbox a').click(function() {
     $("#srch").val($(this).text());
 });
 }
</script>

</body>
</html>