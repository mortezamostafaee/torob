<div id="dlr-recovery">
    
    <form 
    method="post" 
    action="?type=login" 
    autocomplete="off" 
    id="loginForm" 
    onsubmit="return validateMyFormRecovery();"
    >
        
		<div class="dlr-login-input">
		    
		    <?php 
        	if(isset($_SESSION['wrongUP']) && $_SESSION['wrongUP']) {
        	    echo '<div id="code-alert" class="code-alert">
        	    '. __('No user was found with this email or username', 'dlr').'
        	    </div>';
        	    $_SESSION['wrongUP'] = false;
        	}
        	?>
		    
		    <label class="dlr-login-text" for="dlr-login-input-name-field">
			    <span class="star">*</span>
			    <?php echo __('Email or Username', 'dlr'); ?>
			</label>
		    
			<div class="dlr-login-input-field-wrapper">
				<input 
				name="username"
				type="search"
				autocomplete="off"
				onkeypress="registerNameKeyPress()" 
				class="dlr-login-input-field registerName ltr" 
				id="dlr-login-input-name-field"
				/>
			</div>
			
		</div>
       
		<div class="dlr-login-input">
            
            <label class="dlr-login-text" for="dlr-login-input-password-field">
			    <span class="star">*</span>
			    <?php echo __('Password', 'dlr'); ?>
			</label>
			
			<div class="dlr-login-input-field-wrapper">
				<input 
				name="password"  
				type="password"
				autocomplete="off"
				onkeypress="registerMobileKeyPress()" 
				class="dlr-login-input-field registerMobile ltr" 
				id="dlr-login-input-password-field"
				/>
			</div>
			
		</div>
		
		<div class="dlr-login-input">
            
            <label class="dlr-login-text" for="dlr-login-input-mobile2-field">
			    <span class="star">*</span>
			    <?php echo __('Mobile Number', 'dlr'); ?>
			</label>
			
			<div class="dlr-login-input-field-wrapper">
				<input 
				name="mobile"  
				type="search"
				autocomplete="off"
				onkeypress="registerMobileKeyPress()" 
				class="dlr-login-input-field registerMobile ltr" 
				id="dlr-login-input-mobile2-field"
				/>
			</div>
			
		</div>
		
		<div class="recovery-alert"><?php echo __('Please enter your mobile number', 'dlr'); ?></div>
		
		<?php 
		    if( esc_attr($header['_dlr_google_captcha_in_recovery_form']) == 1 ) {
		        echo '<div class="g-recaptcha" data-callback="activeLogin" data-sitekey="'.esc_attr($header['_dlr_google_recaptchav2_site_key']).'"></div>';
		        $disabled = 'disabled="disabled"';
		        
		        echo '<script>function activeLogin(){document.querySelector("#dlr-recovery-btn").disabled=false;}</script>';
		    }else {
		        $disabled = '';
		    }
		?>
		
		<input 
		id="dlr-recovery-btn"
		value="<?php echo __('Recovery', 'dlr'); ?>"
		name="dlr-recovery" 
		type="submit" 
		class="dlr-login-button" 
		<?php echo $disabled; ?>
		/>
	
	</form>
    	    
</div>