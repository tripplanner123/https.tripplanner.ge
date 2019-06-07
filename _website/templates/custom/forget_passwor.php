<?php defined('DIR') OR exit; ?>
<div class="RegLogPageDiv">
	<div class="RegLogInsidePage"> 
		<div class="container" style="padding: 0 0 120px 0;">
			<div class="row">
				<div class="col-sm-12">
					<div class="LoginFormLeft">
						<h3 class="PageTitle text-center">
							<label><?=menu_title(70)?></span>
						</h3>
						<div class="LogRegTitle"><?=menu_title(70)?></div>
						
						<div class="DropDownLogin">
							<div class="row">
								<form action="javascript:void(0)" method="post">
									<div class="form-group col-md-offset-3 col-sm-6">
										<div class="MaterialForm forget-email-box">
											<input type="text" class="forget-email" name="forget-email" value="">
											<span class="highlight"></span>
											<span class="bar"></span>
											<label><?=l("email")?></label>
											<div class="ErrorText gErrorText"></div>
										</div>					
									</div>
									<div class="form-group col-md-offset-3 col-sm-6 forget-secrite-group" style="display: none">
										<div class="MaterialForm forget-secrite-box">
											<input type="text" class="forget-secrite" name="forget-secrite" value="">
											<span class="highlight"></span>
											<span class="bar"></span>
											<label><?=l("recovercode")?></label>
											<div class="ErrorText gErrorText"></div>
										</div>					
									</div>								
									
									<div class="form-group" style="width: 270px; margin-left: calc(50% - 135px); clear:both">
										<button type="submit" class="GreenCircleButton recover-password-button"><?=l("recover")?></button>					
									</div> 
								</form>
							</div>
						</div>

					</div>
				</div>
				




			</div>
		</div>
	</div>
</div>