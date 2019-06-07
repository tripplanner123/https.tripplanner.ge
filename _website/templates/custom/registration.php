<?php 
defined('DIR') OR exit; 
if(isset($_SESSION["trip_user"])){
	unset($_SESSION["trip_user"]);
}
if(isset($_SESSION["trip_user_info"])){
	unset($_SESSION["trip_user_info"]);
}

require_once('_plugins/php-graph-sdk-5.x/src/Facebook/autoload.php'); 
$fb = new Facebook\Facebook([
	'app_id' => '1985700118125179', // Replace {app-id} with your app id
	'app_secret' => '7a90c0447042b3290718a670f199f028',
	'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://tripplanner.ge/'.l().'/?ajax=true&fb-callback=true', $permissions);
?>
<div class="RegLogPageDiv">
	<div class="RegLogInsidePage"> 
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="LoginFormLeft">
						<h3 class="PageTitle text-center">
							<label><?=l("login")?></span>
						</h3>
						<div class="LogRegTitle"><?=l("login")?></div>
						<div class="col-sm-12 text-center">
							<a href="<?=$loginUrl?>" class="FacebookLogin" style="background: url('_website/img/fb_login_<?=l()?>.png') no-repeat; background-position: center; width: 100%;"></a>
						</div>
						<div class="DropDownLogin">
							<div class="Title"><?=l("or")?></div>
							<div class="row">
								<form action="javascript:void(0)" method="post">
									<?php
									echo sprintf("<input type=\"hidden\" name=\"CSRF_token\" value=\"%s\">", @$_SESSION["CSRF_token"]);
									?>
									<div class="form-group col-sm-12">
										<div class="MaterialForm login-email-box">
											<input type="text" class="login-email" name="login-email" value="" autocomplete="off" />
											<span class="highlight"></span>
											<span class="bar"></span>
											<label><?=l("email")?></label>
											<div class="ErrorText gErrorText"></div>
										</div>					
									</div>
									<div class="form-group col-sm-12">
										<div class="MaterialForm login-password-box">
											<input type="password" class="login-password" name="login-password" value="" autocomplete="off" />
											<span class="highlight"></span>
											<span class="bar"></span>
											<label><?=l("password")?></label>
											<div class="ErrorText gErrorText"></div>
										</div>					
									</div>								
									<div class="form-group col-sm-6 margin_0">
										<a href="/<?=l()?>/forget-password" class="ForgetPassLink"><?=menu_title(70)?><span style="font-family: 'DejaVuSans';">?</span></a>
									</div>
									<div class="form-group col-sm-5 margin_0 LoginButton">
										<button type="submit" class="GreenCircleButton loginButtonTri"><?=l("login")?></button>					
									</div> 
								</form>
							</div>
						</div>

					</div>
				</div>
				<div class="col-sm-6">
					<div class="RegistrationFormRight RightBackground">
						<h3 class="PageTitle text-center">
							<label><?=l("registration")?></span>
						</h3>						
						<div class="LogRegTitle"><?=l("registration")?></div>
						<div class="ProfileForm"> 
							<form action="javascript:void(0)" method="post">
								<?php 
								echo sprintf("<input type=\"hidden\" name=\"CSRF_token\" value=\"%s\">", @$_SESSION["CSRF_token"]);
								?>
								<div class="form-group col-sm-6">
									<div class="MaterialForm first-name-box">
										<input type="text" name="first-name" class="first-name" value="" /> <!-- class="gErrorRedLine" -->
										<span class="highlight"></span>
										<span class="bar"></span>
										<label><?=l("firstname")?></label>
										<div class="ErrorText gErrorText"></div>
									</div>					
								</div>
								<div class="form-group col-sm-6">
									<div class="MaterialForm last-name-box">
										<input type="text" name="last-name" class="last-name" value="">
										<span class="highlight"></span>
										<span class="bar"></span>
										<label><?=l("lastname")?></label>
										<div class="ErrorText gErrorText"></div>
									</div>					
								</div>
								<div style="clear:both; width: 100%; height: 1px;"></div>
								<div class="form-group col-sm-6">
									<div class="MaterialForm id-number-box">
										<input type="text" name="id-number" class="id-number" value="">
										<span class="highlight"></span>
										<span class="bar"></span>
										<label><?=l("idnumber")?></label>
										<div class="ErrorText gErrorText"></div>
									</div>					
								</div>
								<div class="form-group col-sm-6">
									<div class="MaterialForm birthday-box">
										<input type="text" name="birthday" value="" class="DatePicker2 birthday" readonly="readonly">
										<span class="highlight"></span>
										<span class="bar"></span>
										<label><?=l("birthdaydate")?></label>
										<i class="fa fa-calendar"></i>
										<div class="ErrorText gErrorText"></div>
									</div>					
								</div>
								<div style="clear:both; width: 100%; height: 1px;"></div>
								<div class="form-group col-sm-6">
									<div class="MaterialForm mobile-number-box">
										<input type="number" name="mobile-number" class="mobile-number" value="" style="width: 100%; padding: 15px 10px 11px 0px">
										<span class="highlight"></span>
										<span class="bar"></span>
										<label><?=l("mobile")?></label>
										<div class="ErrorText gErrorText"></div>
									</div>					
								</div>
								<div class="form-group col-sm-6">
									<div class="MaterialForm email-address-box">
										<input type="text" name="email-address" class="email-address" value="">
										<span class="highlight"></span>
										<span class="bar"></span>
										<label><?=l("email")?></label>
										<div class="ErrorText gErrorText"></div>
									</div>					
								</div>
								<div style="clear:both; width: 100%; height: 1px;"></div>
								<div class="form-group col-sm-6">
									<div class="MaterialForm password-box">
										<input type="password" name="user-password" class="user-password" value="" autocomplete="off" />
										<span class="highlight"></span>
										<span class="bar"></span>
										<label><?=l("password")?></label>
										<div class="ErrorText gErrorText"></div>
									</div>					
								</div>
								<div class="form-group col-sm-6">
									<div class="MaterialForm password-confirm-box">
										<input type="password" name="password-confirm" class="password-confirm" value="">
										<span class="highlight"></span>
										<span class="bar"></span>
										<label><?=l("passwordconfirm")?></label>
										<div class="ErrorText gErrorText"></div>
									</div>					
								</div>
								<div style="clear:both; width: 100%; height: 1px;"></div>
								

								<div class="regdivvv">
									<div class="form-group col-sm-6 TermsAndConditions" style="margin-bottom: 0px;"> 
										<input class="TripCheckbox terms-conditions" id="1" name="terms-conditions" type="checkbox" value="1" />
										<label class="pull-left Text" for="1"><a href="/<?=l()?>/rules" target="_blank"><?=menu_title(209)?></a></label>
									</div>
									<div style="clear: both; width:100%; height: 1px;"></div>
									<div class="form-group col-sm-12 text-right">
										<div class="MaterialForm">
											 <button type="submit" class="RegistrationButton"><?=l("registration")?></button>
										</div>					
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.DatePicker2').datepicker({
	  format: 'yyyy-mm-dd',
	  autoclose:true, 
	  language:'<?=l()?>'
	});
</script>