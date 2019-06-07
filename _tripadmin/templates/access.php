<?php
///////////////////////////////////////////////////////////////////////////
//
// login.php
//
// Copyright ©, Digital Design Ltd., 2011
//
///////////////////////////////////////////////////////////////////////////
?>
<?php defined('DIR') OR exit; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Digital Design Smart CMS</title>
    <base href="<?php echo href() ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo CMS; ?>/css/login-en.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/tiptip/tipTip.css" media="screen" title="no title" charset="utf-8">
    <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/height-cms.js"></script>
    <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery-1.4.1.min.js"></script>
    <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/tiptip/jquery.tipTip.js"></script>
</head>
<body>


<div id="digital"></div>

<div id="footer">
	<div id="part">
    	<br />
    	<br />
		<img src="<?php echo CMS; ?>/img/login-logo.png" width="276" height="21" alt="" />
    	<br />
		<div id="login" class="fix">
<?php if (isset($_POST['dd_login'])) { ?>
			<div id="boxred">
				<div id="partred">
                	<?php // echo a("password.alert"); 
						echo $message;
					?>
                </div>
            </div>
<?php } else { ?>        
			<div id="box">
				<div id="part">
                	&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div>
<?php } ?>        
			<div style="clear:both;"></div>
			<form action="<?php echo ahref(array('access', 'login')) ?>" method="post" name="loginform" id="loginform" style="width:300px; padding-left:170px;">
				<input type="hidden" name="dd_login" value="1">
                <div class="list fix">
                    <div class="name">Username: <span class="star" title="<?php echo a('tt.username');?>">*</span></div>			
                    <input type="text" class="inp" name="username" id="user_login" value="" />
                </div>		
                <div class="list fix">
                    <div class="name">Password: <span class="star" title="<?php echo a('tt.password');?>">*</span></div>			
                    <input type="password" class="inp" name="password" id="user_password" value="" />
                </div>		
                <input type="submit" name="perform" id="login2" class="br blue" alt="Sign In" value="Sign In" />
            </form>
			</div>
			<span id="copyright">Copyright &copy; 2011 <a href="http://www.digitaldesign.ge" target="_blank">Digital Design</a>. All rights reserved.</span>
        </div>
	</div>
</div>

<div id="tiptip_holder" class="tip_left_top">
	<div id="tiptip_content">
		<div id="tiptip_arrow">
			<div id="tiptip_arrow_inner"></div>
		</div>
	</div>
</div>
<script language="javascript">
	$(function(){
		$(".star").tipTip();
	});
</script>
</body>
</html>