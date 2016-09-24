<div id="captchaDiv">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<p>After confirm the code below you will receive an email with your new password.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div id="modal-email" class="form-group">
				<label>email <span class="text-danger">*</span></label>
				<input type="email" name="email" id="input-modal-email" class="form-control form-control-custom" placeholder="" tabindex="4" required>
			</div>
		</div>
	</div>
	<div class="row text-center">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<form class="form-inline">
				<div class="form-group">
					<img id="captcha" src="../lib/securimage/securimage_show.php" alt="CAPTCHA Image" />
					<input class="form-control form-control-custom" type="text" name="captcha_code" id="input-modal-captcha" size="10" maxlength="6" />
					<a href="#" onclick="document.getElementById('captcha').src ='../lib/securimage/securimage_show.php?' + Math.random(); return false"><img style="marginLeft:10px;"src="../lib/securimage/images/refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()" align="bottom" border="0" /></a>
				</div>
			</form>
		</div>
	</div>
	
	<div id="captcha-success" class="alert alert-success" role="alert" style="margin-top: 10px;" hidden><i class="fa fa-check"></i> We sent you an email with instructions so you can complete your password change process. If you don\'t receive any email from us shortly, please check your spam folder.</div>
	<div id="captcha-error" class="alert alert-danger" role="alert" style="margin-top: 10px;" hidden><i class="fa fa-close"></i> Code incorrect. Please try again</div>
</div>