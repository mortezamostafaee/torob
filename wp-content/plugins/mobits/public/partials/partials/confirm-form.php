<script>
var autoConfirm = '<?php echo esc_attr($header['_dlr_auto_confirm']); ?>';
</script>

<div id="dlr-login" class="tabcontent active">
    	    
<form 
method="post" 
action="" 
autocomplete="off" 
id="checkConfirm"
onsubmit="return confirmValidate();"
>

	<div class="dlr-login-input">
	    
	    <label class="dlr-login-text" for="codeBox1">
		    <span class="star">*</span>
		    <?php echo __('Enter the code sent to your mobile', 'dlr'); ?>
		</label>
	    
		<div class="dlr-login-input-field-wrapper confirmCode">
		    
		    <input name="userCode" id="userCode" type="hidden" value="" />
		    
			<input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="codeBox1" onkeypress="repeatCodeAgain()" autofocus type="tel" maxlength="1" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)"/>
			<input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="codeBox2" type="tel" maxlength="1" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)"/>
			<input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="codeBox3" type="tel" maxlength="1" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)"/>
			<input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="codeBox4" type="tel" maxlength="1" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)"/>
			
			<input name="codeMobile" type="hidden" id="codeMobile" />
			
		</div>

	</div>
	<?php 
	if(isset($_SESSION['wrongCode']) && $_SESSION['wrongCode']) {
	    echo '<div id="code-alert" class="code-alert">'.__('The code entered is incorrect.', 'dlr').'</div>';
	    $_SESSION['wrongCode'] = false;
	}
	?>
	<div class="login-register-alert"></div>
	<button 
		   type="submit" 
		   id="continueCode" 
		   name="dlr-checkCode" 
		   class="dlr-login-button"
	>
	    <div class="lds-ellipsis" id="confirm-loader"><div></div><div></div><div></div><div></div></div>
        
        <span id="confirm-continue"><?php echo __('Next', 'dlr'); ?></span>
	</button>
	<div id="endTimeCode">
	    <?php echo __('Your time is up', 'dlr'); ?>
	</div>
	
	<span id="time">--:--</span>

</form>

<form
method="post"
action=""
onsubmit="return repeatValidate();"
id="dlr-repeat-form"
></form>
<script>
        var mobile = localStorage.getItem('dlr-mobile');
        document.getElementById('codeMobile1').value = localStorage.getItem('dlr-mobile');
        document.getElementById('codeMobile').value = localStorage.getItem('dlr-mobile');
    </script>
</div>