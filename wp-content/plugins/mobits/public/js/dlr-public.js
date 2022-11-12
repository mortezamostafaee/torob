function openTab(evt, cityName) 
{
    var i, tabcontent, tablinks;
    
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
    	tabcontent[i].style.display = "none";
    }
    
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
    	tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

function openRegister()
{
    openTab(event, 'dlr-register');
    document.getElementById('dlr_login_tab').classList.remove('active');
    document.getElementById('dlr_register_tab').classList.add('active');
}

function loginValidate()
{
    
    const mobile = document.querySelector('.loginMobile').value;
    
    var errorText = "لطفا شماره موبایل خود را وارد نمایید.";
    var errorText2 = "لطفا یک شماره موبایل معتبر وارد نمایید.";
    
    const errorBox = document.querySelector('.login-register-alert');
    
    if( mobile == '' )
    { 
        errorBox.innerHTML = errorText;
        errorBox.setAttribute('style', 'display: block !important');
        return false;
    }
    
    if( mobile.length !== 11 || ! /(\+98|0|98|0098)?([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/.test(fixNumbers(mobile)) )
    {
      errorBox.innerHTML = errorText2;
      errorBox.setAttribute('style', 'display: block !important');
      return false;
    }
    
    if ( mobile.charAt(0) == '0' ) {
        localStorage.setItem('dlr-mobile', mobile);
    }else {
        localStorage.setItem('dlr-mobile', '0'+mobile);
    }
    
    
    var current = Number (Math.round(+new Date()/1000) );
    
    if ( ! localStorage.getItem('dlr-start') ) 
    {
        localStorage.setItem('dlr-start', current );
    }
    else 
    {
        var dlr_start = Number( localStorage.getItem('dlr-start') );
        
        if( current - dlr_start > resendTime ) 
        {
            localStorage.setItem('dlr-start', current );
        }
    }
    
    return true;
}

function dlrTimer() 
{
    var dlr_start = Number( localStorage.getItem('dlr-start') );
    var current = Number( Math.round(+new Date()/1000) );
    
    var time = current - dlr_start;
    
    if( time > resendTime ) 
    {
        document.getElementById('continueCode').setAttribute('style', 'display:none !important');
        document.getElementById('time').setAttribute('style', 'display:none !important');

        document.getElementById('endTimeCode').setAttribute('style', 'display:block !important');
        
        var mobile = localStorage.getItem('dlr-mobile')
        document.querySelector("#dlr-repeat-form").innerHTML = '<input name="codeMobile" type="hidden" id="codeMobile1" value="'+mobile+'" /><input type="submit" name="dlr-sendAgain" class="repeatCode" value="'+sendAgainBtnValue+'">';
            
        document.getElementById('codeBox1').disabled = true;
        document.getElementById('codeBox2').disabled = true;
        document.getElementById('codeBox3').disabled = true;
        document.getElementById('codeBox4').disabled = true;
    }
    
    else {
        
        var remain = resendTime - time,
		display = document.querySelector('#time');
		startTimer(remain, display);
        
    }
}

function startTimer(duration, display) 
{
	var timer = duration, minutes, seconds;
	setInterval(function () {
		minutes = parseInt(timer / 60, 10);
		seconds = parseInt(timer % 60, 10);

		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;

		display.textContent = minutes + ":" + seconds;
		if (--timer < 0) 
		{
		    
			document.querySelector( '#time' ).setAttribute('style', 'display:none !important');
			document.getElementById('endTimeCode').setAttribute('style', 'display:block !important');
			
			if( !document.getElementById("codeMobile1") ) 
			{
			    var mobile = localStorage.getItem('dlr-mobile');
			    
                document.querySelector("#dlr-repeat-form").innerHTML = '<input name="codeMobile" type="hidden" id="codeMobile1" value="'+mobile+'" /><input type="submit" name="dlr-sendAgain" class="repeatCode" value="'+sendAgainBtnValue+'">';
			}
			
            document.getElementById('continueCode').setAttribute('style', 'display:none !important');
            document.querySelector('.login-register-alert').setAttribute('style', 'display:none !important');
            
            document.getElementById('codeBox1').disabled = true;
            document.getElementById('codeBox2').disabled = true;
            document.getElementById('codeBox3').disabled = true;
            document.getElementById('codeBox4').disabled = true;
			return;
		}
	}, 1000);
}

function repeatValidate () 
{
    var current = Number (Math.round(+new Date()/1000) );
    localStorage.setItem('dlr-start', current );
    
    return true;
}

var persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g],
arabicNumbers  = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g],
fixNumbers = function (str) {
    if(typeof str === 'string') {
        
    	for(var i=0; i<10; i++)
    	{
    	    str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
    	}
    	
    }
    return str;
};

function onFocusEvent(index) {
    
	for (item = 1; item < index; item++) {
		const currentElement = getCodeBoxElement(item);
		if (!currentElement.value) {
			currentElement.focus();
			break;
		}
	}
}

function loginMobileKeyPress(){
    
	const errorBox = document.querySelector('.login-register-alert');
	errorBox.setAttribute('style', 'display: none !important');
}

function registerMobileKeyPress(){
    
	const errorBox = document.querySelector('.register-register-alert');
	errorBox.setAttribute('style', 'display: none !important');
}

function registerNameKeyPress(){
    
	const errorBox = document.querySelector('.register-register-alert');
	errorBox.setAttribute('style', 'display: none !important');
}

function registerUsernameKeyPress(){
    
	const errorBox = document.querySelector('.register-register-alert');
	errorBox.setAttribute('style', 'display: none !important');
}

function validateMyFormRecovery() 
{
    const username = document.querySelector('#dlr-login-input-name-field').value;
    const password = document.querySelector('#dlr-login-input-password-field').value;
    const mobile = document.querySelector('#dlr-login-input-mobile2-field').value;
    
    var errorText0 = "لطفا ایمیل یا نام کاربری خود را وارد نمایید.";
    var errorText1 = "لطفا رمز عبور خود را وارد نمایید.";
    var errorText2 = "لطفا شماره موبایل خود را وارد نمایید.";
    var errorText3 = "لطفا یک شماره موبایل معتبر وارد نمایید.";
    
    const errorBox = document.querySelector('.recovery-alert');
    
    if( username == '' )
    { 
        errorBox.innerHTML = errorText0;
        errorBox.setAttribute('style', 'display: block !important');
        return false;
    }
    
    if( password == '' )
    { 
        errorBox.innerHTML = errorText1;
        errorBox.setAttribute('style', 'display: block !important');
        return false;
    }
    
    if( mobile == '' )
    { 
        errorBox.innerHTML = errorText2;
        errorBox.setAttribute('style', 'display: block !important');
        return false;
    }
    
    if( ! /(\+98|0|98|0098)?([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/.test(fixNumbers(mobile)) )
    {
        errorBox.innerHTML = errorText3;
        errorBox.setAttribute('style', 'display: block !important');
        return false;
    }
  
    localStorage.setItem('dlr-mobile', mobile);
    
    var current = Number (Math.round(+new Date()/1000) );
    
    if ( ! localStorage.getItem('dlr-start') ) 
    {
        localStorage.setItem('dlr-start', current );
    }
    else 
    {
        var dlr_start = Number( localStorage.getItem('dlr-start') );
        
        if( current - dlr_start > resendTime ) 
        {
            localStorage.setItem('dlr-start', current );
        }
    }

    return true;
}

function validateMyFormRegister()
{
    const name = document.querySelector('.registerName').value;
    const mobile = document.querySelector('.registerMobile').value;
    
    var errorText0 = "لطفا نام و نام خانوادگی خود را وارد نمایید.";
    var errorText1 = "لطفا شماره موبایل خود را وارد نمایید.";
    var errorText2 = "لطفا یک شماره موبایل معتبر وارد نمایید.";
    var errorText4 = "لطفا نام کاربری خود را وارد نمایید.";
    var errorText5 = "نام کاربری باید حداقل 6 کلمه باشد.";
    
    const errorBox = document.querySelector('.register-register-alert');
    
    if( name == '' )
    { 
        errorBox.innerHTML = errorText0;
        errorBox.setAttribute('style', 'display: block !important');
        return false;
    }
	
	if(document.querySelector('#dlr-login-input-username-field')){
	   const usernameMain = document.querySelector('#dlr-login-input-username-field').value;
		
	   if( usernameMain == '' )
		{ 
			errorBox.innerHTML = errorText4;
			errorBox.setAttribute('style', 'display: block !important');
			return false;
		}

		if( usernameMain.length < 6 )
		{ 
			errorBox.innerHTML = errorText5;
			errorBox.setAttribute('style', 'display: block !important');
			return false;
		}
	}
    
    if( mobile == '' )
    { 
        errorBox.innerHTML = errorText1;
        errorBox.setAttribute('style', 'display: block !important');
        return false;
    }
    
    if( mobile.length !== 11 || ! /(\+98|0|98|0098)?([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/.test(fixNumbers(mobile)) )
    {
        errorBox.innerHTML = errorText2;
        errorBox.setAttribute('style', 'display: block !important');
        return false;
    }
  
    localStorage.setItem('dlr-mobile', mobile);
    
    var current = Number (Math.round(+new Date()/1000) );
    
    if ( ! localStorage.getItem('dlr-start') ) 
    {
        localStorage.setItem('dlr-start', current );
    }
    else 
    {
        var dlr_start = Number( localStorage.getItem('dlr-start') );
        
        if( current - dlr_start > resendTime ) 
        {
            localStorage.setItem('dlr-start', current );
        }
    }

    return true;
}

function repeatCodeAgain()
{
    if( document.getElementById('code-alert') )
    {
        document.querySelector('.code-alert').setAttribute('style', 'display:none !important');
    }
    
}

function confirmValidate()
{
    
    const codeBox1 = document.querySelector('#codeBox1').value;
    const codeBox2 = document.querySelector('#codeBox2').value;
    const codeBox3 = document.querySelector('#codeBox3').value;
    const codeBox4 = document.querySelector('#codeBox4').value;
    
    document.getElementById('userCode').value = codeBox1+codeBox2+codeBox3+codeBox4;
    
    var errorText = "لطفا کد تایید را بصورت کامل وارد نمایید.";
    
    const errorBox = document.querySelector('.login-register-alert');
    
    if( codeBox1 == '' || codeBox2 == '' || codeBox3 == '' || codeBox4 == '' )
    { 
        errorBox.innerHTML = errorText;
        errorBox.setAttribute('style', 'display: block !important');
        return false;
    }

    return true;
}

function goTimer(delay)
{
	if(Number(delay)>resendTime)
	{
		var el = document.querySelector( '#time' );
		el.setAttribute('style', 'display:none !important');
		document.getElementById("continueCode").disabled = true;
// 		document.querySelector( '.repeatCode' ).setAttribute('style', 'display:inline-block !important');

		var mobile = localStorage.getItem('dlr-mobile')
        document.querySelector("#dlr-repeat-form").innerHTML = '<input name="codeMobile" type="hidden" id="codeMobile1" value="'+mobile+'" /><input type="submit" name="dlr-sendAgain" class="repeatCode" value="ارسال مجدد کد">';
            
	}
	else
	{
		window.onload = function () {
			var fiveMinutes = resendTime-delay,
			display = document.querySelector('#time');
			startTimer(fiveMinutes, display);
		};
	}
}

/**
 * code cofirmation
 */
function getCodeBoxElement(index) 
{
	return document.getElementById('codeBox' + index);
}
function onKeyUpEvent(index, event) 
{
	const eventCode = event.which || event.keyCode;
	if (getCodeBoxElement(index).value.length === 1) 
	{
		if (index !== 4) {
			getCodeBoxElement(index+ 1).focus();
		} else 
		{
			getCodeBoxElement(index).blur();
		
			var condebox1 = document.getElementById('codeBox1').value;
			var condebox2 = document.getElementById('codeBox2').value;
			var condebox3 = document.getElementById('codeBox3').value;
			var condebox4 = document.getElementById('codeBox4').value;

			document.getElementById('userCode').value = condebox1+condebox2+condebox3+condebox4;

            if(Number(autoConfirm)) 
            {
                document.getElementById('confirm-loader').setAttribute('style', 'display: block !important');
    			document.getElementById('confirm-continue').setAttribute('style', 'display: none !important');
    			document.getElementById('continueCode').style.cursor = 'auto';
    			document.getElementById('continueCode').click();
    			document.getElementById("continueCode").disabled = true;
            }
			
        }
    }
    
    if (eventCode === 8 && index !== 1) {
    	getCodeBoxElement(index - 1).focus();
    }
}

function onFocusEvent(index) {
	for (item = 1; item < index; item++) {
		const currentElement = getCodeBoxElement(item);
		if (!currentElement.value) {
			currentElement.focus();
			break;
		}
	}
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
