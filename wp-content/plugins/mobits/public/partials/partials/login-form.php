<?php 
if( esc_attr($header['_dlr_login_status']) == 1 ):
$checkout = isset($_GET['back']) ? '&back='.$_GET['back'] : '';
?>
<div id="dlr-login" class="tabcontent active">
	<form 
	autocomplete="off"
	method="post" 
	action="?type=login<?php echo $checkout; ?>" 
	id="dlr-login-form"
	onsubmit="return loginValidate();"
	type="search"
	>
	
		<div class="dlr-login-input">
		    
		    <?php 
        	if(isset($_GET['status']) && $_GET['status']==0) 
        	{
        	    echo '<div id="code-alert" class="code-alert">
        	    '. __('No user was found with this mobile number', 'dlr').' 
        	    <span id="not_registered" onclick="openRegister(event)">
        	    '. __('Register', 'dlr').'
        	    </span></div>';
        	}
        	?>
		    
		    <?php if(isset($_GET['back']) && $_GET['back'] == 'checkout' && esc_attr($options['_dlr_checkout_notif']) == 1 ): ?>
		        <div class="forceLogin">
		            <?php echo __('Log in or register to continue ordering', 'dlr'); ?>
		        </div>
		    <?php endif; ?>
		    
			<label class="dlr-login-text" for="dlr-login-input-mobile-field">
			    <span class="star">*</span>
			    <?php echo __('Enter your mobile number', 'dlr'); ?>
			</label>
			
			<div class="dlr-login-input-field-wrapper">
			    <!--<div id="myDropdown" class="dropdown-content">-->
       <!--             <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">-->
       <!--             <a>Afghanistan <img src="https://dashboard.clicksend.com/assets/img/vendor/flag-icon-css/flags/4x3/mf.svg" /></a>-->
       <!--             <a>Base</a>-->
       <!--             <a>Blog</a>-->
       <!--             <a>Contact</a>-->
       <!--             <a>Custom</a>-->
       <!--             <a>Support</a>-->
       <!--             <a>Tools</a>-->
       <!--         </div>-->
				<input 
				autocomplete="off" 
				name="loginMobile" 
				type="search"
				value="<?php if( isset($_GET['status']) && $_GET['status']==0 ) echo $_SESSION['dlr_mobile']; ?>"
				class="loginMobile dlr-login-input-field ltr"
				onkeypress="loginMobileKeyPress()" 
				id="dlr-login-input-mobile-field"
			    oninput="if(this.value.length>11) this.value=value.substr(0, value.length - 1)"
				/>
			</div>
			
		</div>
		
		<div class="login-register-alert"><?php echo __('Please enter your mobile number', 'dlr'); ?></div>
		
		<?php 
		    if( esc_attr($header['_dlr_google_captcha_in_login_form']) == 1 ) {
		        echo '<div class="g-recaptcha" data-callback="activeLogin" data-sitekey="'.esc_attr($header['_dlr_google_recaptchav2_site_key']).'"></div>';
		        $disabled = 'disabled="disabled"';
		        
		        echo '<script>function activeLogin(){document.querySelector("#dlr-login-btn").disabled=false;}</script>';
		    }else {
		        $disabled = '';
		    }
		?>
		
		<input 
		id="dlr-login-btn"
		type="submit" 
		class="dlr-login-button" 
		name="dlr-login" 
		value="<?php echo __('Log in', 'dlr'); ?>"
		<?php echo $disabled; ?>
		>
		
		<?php if( esc_attr($options['_dlr_recovery_status']) == 1 ): ?>
		<div>
		    <a href="?type=recovery" class="do_login_with_eu">
		        <?php echo __('Already registered by email or username?', 'dlr'); ?>
		    </a>
		</div>
		<?php endif; ?>
		
	</form>
</div>
<?php endif; ?>