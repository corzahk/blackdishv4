<?php

?>

<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="icon-settings icons ic"></i> <?=$lang['dash']['set_title']?>
		<p><a href="<?=path?>">Dashboard</a> <i class="fas fa-long-arrow-alt-right"></i> <?=$lang['dash']['settings']?></p>
	</div>
</div>


<div class="pt-box mt-4">
	<h3 class="cp-form-title mt-0"><?=$lang['dash']['set_title']?></h3>
	<form class="pt-sendsettings">
	<div class="pt-admin-setting">
		<div class="form-row">
			<div class="col">
				<div class="form-group">
					<label><?=$lang['dash']['set_logo']?></label>
					<div class="file-upload">
					  <div class="file-select">
					    <div class="file-select-button" id="fileName2"><?=$lang['details']['image_c']?></div>
					    <div class="file-select-name" id="noFile2"><?=$lang['details']['image_n']?></div>
					    <input type="file" name="chooseFile" id="chooseFile2">
					  </div>
					</div>
					<input type="hidden" name="site_logo" rel="#dropZone2" value="<?=site_logo?>">
					<div id="thumbnails2"><img src="<?=site_logo?>" onerror="this.src='<?=nophoto?>'" class="nophoto" /></div>
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label><?=$lang['dash']['set_favicon']?></label>
					<div class="file-upload">
					  <div class="file-select">
					    <div class="file-select-button" id="fileName1"><?=$lang['details']['image_c']?></div>
					    <div class="file-select-name" id="noFile1"><?=$lang['details']['image_n']?></div>
					    <input type="file" name="chooseFile" id="chooseFile1">
					  </div>
					</div>
					<input type="hidden" name="site_favicon" rel="#dropZone1" value="<?=site_favicon?>">
					<div id="thumbnails1"><img src="<?=site_favicon?>" onerror="this.src='<?=nophoto?>'" class="nophoto" /></div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label><?=$lang['dash']['set_stitle']?></label>
			<input type="text" name="site_title" value="<?=site_title?>">
		</div>
		<div class="form-group">
			<label><?=$lang['dash']['set_keys']?></label>
			<input type="text" name="site_keywords" value="<?=site_keywords?>">
		</div>
		<div class="form-group">
			<label><?=$lang['dash']['set_desc']?></label>
			<textarea name="site_description"><?=site_description?></textarea>
		</div>
		<div class="form-group">
			<label><?=$lang['dash']['set_url']?></label>
			<input type="text" name="site_url" value="<?=site_url?>">
		</div>

		<div class="form-group">
			<label><?=$lang['dash']['set_noreply']?></label>
			<input type="text" name="site_noreply" value="<?=site_noreply?>">
		</div>
		<div class="form-row">
			<div class="col">
				<div class="form-group">
					<label>Facebook</label>
					<input type="text" name="site_facebook" value="<?=site_facebook?>">
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label>Twitter</label>
					<input type="text" name="site_twitter" value="<?=site_twitter?>">
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label>Instagram</label>
					<input type="text" name="site_instagram" value="<?=site_instagram?>">
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label>Youtube</label>
					<input type="text" name="site_youtube" value="<?=site_youtube?>">
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label>Skype</label>
					<input type="text" name="site_skype" value="<?=site_skype?>">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>ipinfo</label>
			<input type="password" name="ipinfo" value="<?=ipinfo?>">
		</div>


		<div class="form-group">
			<input class="tgl tgl-light" id="cb1" value="1" name="site_register" type="checkbox"<?=(site_register ? ' checked' : '')?>/>
			<label class="tgl-btn" for="cb1"></label>
			<label><?=$lang['dash']['set_register']?></label>
		</div>
		<h3 class="cp-form-title">Taxes %</h3>
		<div class="form-group">
			<label>Percentage %</label>
			<input type="text" name="taxes" class="money" value="<?=taxes?>">
		</div>

		<h3 class="cp-form-title">Facebook login</h3>
		<div class="form-group">
			<input class="tgl tgl-light" id="cb2" value="1" name="login_facebook" type="checkbox"<?=(login_facebook ? ' checked' : '')?>/>
			<label class="tgl-btn" for="cb2"></label>
			<label>Facebook Login</label>
		</div>
		<div class="form-row">
			<div class="col-5 form-group">
				<label>App id</label>
				<input type="text" name="login_fbAppId" placeholder="Facebook App Id" value="<?=login_fbAppId?>">
			</div>
			<div class="col-5 form-group">
				<label>App secret</label>
				<input type="password" name="login_fbAppSecret" placeholder="Facebook app secret" value="<?=login_fbAppSecret?>">
			</div>
			<div class="col form-group">
				<label>App version</label>
				<input type="text" name="login_fbAppVersion" placeholder="Facebook app version" value="<?=login_fbAppVersion?>">
			</div>
		</div>
		<p><i class="fas fa-exclamation-triangle"></i> The Redirect Url: <b><?=path?>/login-facebook.php</b></p>

		<h3 class="cp-form-title">Twitter login</h3>
		<div class="form-group">
			<input class="tgl tgl-light" id="cb3" value="1" name="login_twitter" type="checkbox"<?=(login_twitter ? ' checked' : '')?>/>
			<label class="tgl-btn" for="cb3"></label>
			<label>Twitter Login</label>
		</div>
		<div class="form-row">
			<div class="col form-group">
				<label>App Key</label>
				<input type="text" name="login_twConKey" placeholder="Twitter App Key" value="<?=login_twConKey?>">
			</div>
			<div class="col form-group">
				<label>App secret</label>
				<input type="password" name="login_twConSecret" placeholder="Twitter App Secret" value="<?=login_twConSecret?>">
			</div>
		</div>
		<p><i class="fas fa-exclamation-triangle"></i> The Redirect Url: <b><?=path?>/login-twitter.php</b></p>

		<h3 class="cp-form-title">Google login</h3>
		<div class="form-group">
			<input class="tgl tgl-light" id="cb4" value="1" name="login_google" type="checkbox"<?=(login_google ? ' checked' : '')?>/>
			<label class="tgl-btn" for="cb4"></label>
			<label>Google Login</label>
		</div>
		<div class="form-row">
			<div class="col form-group">
				<label>Client id</label>
				<input type="text" name="login_ggClientId" placeholder="Google client id" value="<?=login_ggClientId?>">
			</div>
			<div class="col form-group">
				<label>Client secret</label>
				<input type="password" name="login_ggClientSecret" placeholder="Google client Secret" value="<?=login_ggClientSecret?>">
			</div>
		</div>
		<p><i class="fas fa-exclamation-triangle"></i> The Redirect Url: <b><?=path?>/login-google.php</b></p>

		<h3 class="cp-form-title">Paypal</h3>
		<div class="form-group">
			<input class="tgl tgl-light" id="cb5" value="1" name="site_paypal_live" type="checkbox"<?=(site_paypal_live ? ' checked' : '')?>/>
			<label class="tgl-btn" for="cb5"></label>
			<label>Live</label>
		</div>
		<div class="form-row">
			<div class="col form-group">
				<label>Paypal id</label>
				<input type="text" name="site_paypal_id" placeholder="Paypal id" value="<?=site_paypal_id?>">
			</div>
			<div class="col form-group">
				<label>Client id</label>
				<input type="password" name="site_paypal_client_id" placeholder="Paypal Client id" value="<?=site_paypal_client_id?>">
			</div>
			<div class="col form-group">
				<label>Client Secret</label>
				<input type="password" name="site_paypal_client_secret" placeholder="Paypal Client Secret" value="<?=site_paypal_client_secret?>">
			</div>
			<div class="col-1 form-group">
				<label>Currency</label>
				<input type="text" name="site_currency_name" placeholder="Currency name" value="<?=site_currency_name?>">
			</div>
			<div class="col-1 form-group">
				<label>Symbol</label>
				<input type="text" name="site_currency_symbol" placeholder="Currency Symbol" value="<?=site_currency_symbol?>">
			</div>
		</div>

		<h3 class="cp-form-title">Stripe</h3>
		<div class="form-row">
			<div class="col form-group">
				<label>Publishable key</label>
				<input type="text" name="site_stripe_key" placeholder="Publishable key" value="<?=site_stripe_key?>">
			</div>
			<div class="col form-group">
				<label>Secret key</label>
				<input type="password" name="site_stripe_secret" placeholder="Secret key" value="<?=site_stripe_secret?>">
			</div>
		</div>

		<h3 class="cp-form-title">PHPMailer SMTP</h3>
		<div class="form-group">
			<input class="tgl tgl-light" id="cb6" value="1" name="site_smtp" type="checkbox"<?=(site_smtp ? ' checked' : '')?>/>
			<label class="tgl-btn" for="cb6"></label>
			<label>is SMTP</label>
		</div>
		<div class="form-row">
			<div class="col form-group">
				<label>Host</label>
				<input type="password" name="site_smtp_host" placeholder="SMTP Host" value="<?=site_smtp_host?>">
			</div>
			<div class="col form-group">
				<label>Username</label>
				<input type="password" name="site_smtp_username" placeholder="SMTP Username" value="<?=site_smtp_username?>">
			</div>
			<div class="col form-group">
				<label>Password</label>
				<input type="password" name="site_smtp_password" placeholder="SMTP Password" value="<?=site_smtp_password?>">
			</div>
			<div class="col form-group">
				<label>Port</label>
				<input type="text" name="site_smtp_port" placeholder="SMTP Port" value="<?=site_smtp_port?>">
			</div>
			<div class="col form-group">
				<label>Auth</label>
				<select name="site_smtp_auth">
					<option value="0" <?=(site_smtp_auth=='0'?'selected':'')?>>False</option>
					<option value="1" <?=(site_smtp_auth=='1'?'selected':'')?>>True</option>
				</select>
			</div>
			<div class="col form-group">
				<label>Encryption</label>
				<select name="site_smtp_encryption">
					<option value="none" <?=(site_smtp_encryption=='none'?'selected':'')?>>None</option>
					<option value="tls" <?=(site_smtp_encryption=='tls'?'selected':'')?>>TLS</option>
				</select>
			</div>
		</div>

		<hr>
		<div class="mt-4">
			<button type="submit" class="pt-btn">
				<span><?=$lang['dash']['set_btn']?> <i class="fas fa-arrow-circle-right"></i></span>
			</button>
		</div>
	</div>

	</form>
</div>
