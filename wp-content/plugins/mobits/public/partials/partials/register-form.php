<?php 
if( esc_attr($header['_dlr_register_status']) == 1 ):
$checkout = isset($_GET['back']) ? '&back='.$_GET['back'] : '';
?>

<div id="dlr-register" class="tabcontent <?php if( esc_attr($header['_dlr_login_status']) != 1 ) { echo 'active'; } ?>">
    	    
    <form 
    method="post" 
    action="?type=register<?= $checkout;?>" 
    autocomplete="off" 
    id="loginForm" 
    onsubmit="return validateMyFormRegister();"
    >

		<div class="dlr-login-input">
		    
		    <label class="dlr-login-text" for="dlr-login-input-name-field">
			    <span class="star">*</span>
			    <?php echo __('First name & last name', 'dlr'); ?>
			</label>
		    
			<div class="dlr-login-input-field-wrapper">
				<input 
				name="regName"
				type="search"
				value="<?php echo apply_filters('dlr_register_form_name_input', $name); ?>"
				autocomplete="off"
				onkeypress="registerNameKeyPress()" 
				class="dlr-login-input-field registerName" 
				id="dlr-login-input-name-field"
				/>
			</div>
			
		</div>

		<div class="dlr-login-input">
            
            <label class="dlr-login-text" for="dlr-login-input-mobile2-field">
			    <span class="star">*</span>
			    <?php echo __('Mobile number', 'dlr'); ?>
			</label>
			
			<div class="dlr-login-input-field-wrapper">
				<input 
				name="regMobile"  
				type="search"
				autocomplete="off"
				onkeypress="registerMobileKeyPress()" 
				class="dlr-login-input-field registerMobile ltr" 
				id="dlr-login-input-mobile2-field"
				value="<?php echo apply_filters('dlr_register_form_mobile_input', @$mobile); ?>"
			    oninput="if(this.value.length>11) this.value=value.substr(0, value.length - 1)"
				/>
			</div>
			
		</div>
		<div class="register-register-alert"><?php echo __('Please enter your mobile number', 'dlr'); ?></div>

		<?php do_action('dlr_register_form_after_mobile_input'); ?>

		<?php do_action('dlr_before_register_form_button'); ?>
		
		<?php 
		    if( esc_attr($header['_dlr_google_captcha_in_register_form']) == 1 ) {
		        echo '<div class="g-recaptcha" data-callback="activeLogin" data-sitekey="'.esc_attr($header['_dlr_google_recaptchav2_site_key']).'"></div>';
		        $disabled = 'disabled="disabled"';
		        
		        echo '<script>function activeLogin(){document.querySelector("#dlr-register-btn").disabled=false;}</script>';
		    }else {
		        $disabled = '';
		    }
		?>
		
		<input 
		id="dlr-register-btn"
		value="<?php echo __('Register', 'dlr'); ?>"
		name="dlr-register" 
		type="submit" 
		class="dlr-login-button" 
		<?php echo $disabled; ?>
		/>
		
		<?php if( esc_attr($options['_dlr_recovery_status']) == 1 ): ?>
		<div>
		    <a href="?type=recovery" class="do_login_with_eu">
		        <?php echo __('Already registered by email or username?', 'dlr'); ?>
		    </a>
		</div>
		<?php endif; ?>
	</form>

	<?php do_action('dlr_after_register_form'); ?>
	
</div>
<?php endif; ?>