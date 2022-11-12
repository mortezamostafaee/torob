<?php
$header = get_options("
    '_dlr_dark_mode_status',
    '_dlr_auto_confirm',
    '_dlr_favicon',
    '_dlr_extra_style',
    '_dlr_color_tab',
    '_dlr_login_status',
    '_dlr_register_status',
    '_dlr_page_slug',
    '_dlr_logo',
    '_dlr_description',
    '_dlr_color',
    '_dlr_design_type',
    '_dlr_background_image',
    '_dlr_button_image',
    '_dlr_google_captcha_in_login_form',
    '_dlr_google_captcha_in_register_form',
    '_dlr_google_captcha_in_recovery_form',
    '_dlr_google_recaptchav2_site_key',
    '_dlr_resend_code_time'
");
?>
<!DOCTYPE html>
<html dir="rtl">
    
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo __('Login/Register', 'dlr'); ?></title>
      <link rel="stylesheet" href="<?php echo DLR_BASE_URL . 'public/css/dlr-public.css' ?>" />
      <script>
          var autoConfirm = '<?php echo esc_attr($header['_dlr_auto_confirm']); ?>';
          var sendAgainBtnValue = '<?php echo __("Resend the code", "dlr"); ?>';
          var resendTime = <?php echo esc_attr($header['_dlr_resend_code_time']); ?>;
      </script>
      <script src="<?php echo DLR_BASE_URL . 'public/js/dlr-public.js' ?>" ></script>
      <link rel="shortcut icon" href="<?php echo esc_attr($header['_dlr_favicon']); ?>" type="image/icon">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
      <?php echo '<style>'.esc_attr($header['_dlr_extra_style']).'</style>';?>
      
      <?php 
      if( $header['_dlr_background_image'] !== '' ) {
          echo '<style>#dlr-box{border: 2px solid #fff; box-shadow: 0px 4px 31px 18px #1217391f;}</style>';
          
      }
      if( $header['_dlr_button_image'] == 1 ) {
          echo '<style> .dlr-login-button { background:url('.esc_attr($header["_dlr_background_image"]).'), '.esc_attr($header["_dlr_color"]).'; background-position: center center !important;}</style>';
      }else {
          echo '<style>.dlr-login-button {background:'.esc_attr($header["_dlr_color"]).'}</style>';
      }
      
      if( $header['_dlr_design_type'] == 'classic' )
      {
          ?>
          <style>
          #dlr-header #dlr-tab {
            border: none;
            max-width: 100%;
            margin: 0;
            border-radius: 0;
            box-shadow: none;
          }
          #dlr-box {
            border-radius: 15px;
            overflow: hidden;
          }
          #dlr-header-wrapper {
            margin-bottom: 15px;
          }
          #dlr-header {
              margin-bottom: 14px;
          }
          .dlr-login-input-field {
            border-radius: 8px !important;
            border: 1px solid #bbb !important;
          }
          .dlr-login-button {
              border-radius: 8px !important;
          }
          .login-register-alert, .register-register-alert, .recovery-alert, .forceLogin {
              border-radius: 5px !important;
          }
          </style>
          <?php
      } 
      ?>
      <?php 
      if( esc_attr($header['_dlr_dark_mode_status']) == 1 )
        echo '<link rel="stylesheet" href="'. DLR_BASE_URL .'public/css/dlr-dark.css" />';
        
      if( is_rtl() )
        echo '<link rel="stylesheet" href="'. DLR_BASE_URL .'public/css/dlr-rtl-public.css" />';
        
        
      if(   esc_attr($header['_dlr_google_captcha_in_login_form']) == 1 || 
            esc_attr($header['_dlr_google_captcha_in_register_form']) == 1 || 
            esc_attr($header['_dlr_google_captcha_in_recovery_form']) == 1 )
            {
          $lang = is_rtl() ? '?hl=fa' : '';
          echo '<script src="https://www.google.com/recaptcha/api.js'.$lang.'" async defer></script>';
      }
      ?>
    </head>
   
    <body 
    style="<?php echo 'background-image:url('. esc_attr($header['_dlr_background_image']).')' ; ?>"
    class="<?php if( esc_attr($header['_dlr_dark_mode_status']) == 1 ) echo 'dark'; ?>">
        
        <style>
            .tablinks.active{
            	background: <?php echo esc_attr($header['_dlr_color_tab']); ?>;
            	color: #fff;
            }
        </style>
       
    <main>
      
        <div id="dlr-box">
      
            <div id="dlr-header-wrapper">
    
                <header id="dlr-header">
                    
                	<?php if( ! isset( $_GET['type'] ) ): ?>
                	
                	<div id="dlr-tab">
                	    
                		<?php if( esc_attr($header['_dlr_login_status']) == 1 ): ?>
                		    <button type="button" id="dlr_login_tab" class="tablinks active" onclick="openTab(event, 'dlr-login')"><?php echo __('Login', 'dlr'); ?></button>
                		<?php endif;?>
                		
                		<?php if( esc_attr($header['_dlr_register_status']) == 1 ): ?>
                		    <button type="button" id="dlr_register_tab" class="tablinks <?php if( esc_attr($header['_dlr_login_status']) != 1 ) { echo 'active'; } ?>" onclick="openTab(event, 'dlr-register')"><?php echo __('Register', 'dlr'); ?></button>
                		<?php endif;?>
                		
                	</div>
                	
                	<?php else: ?>
                	
                		<div class="set_code">
                		    
                			<span> 
                			<?php
                			if( isset($_GET['type']) ) 
                			{
                			    switch( $_GET['type'] ) {
                			        case 'login':
                			            echo __('Login', 'dlr');
                			            break;
                			        case 'register':
                			            echo __('Register', 'dlr');
                			            break;
                			        case 'recovery':
                			            echo __('Recovery', 'dlr');
                			            break;
                			    }
                			}
                			; ?> 
                			</span>
                			
                			<a href="<?= bloginfo('url') . '/' . esc_attr($header['_dlr_page_slug']); ?>" id="dlr-back-icon">
                				<svg width="19px" viewBox="0 0 48 48"><path d="M44,26H2a2,2,0,0,1,0-4H44A2,2,0,0,1,44,26Z" fill="#3ec2bd"/>
                				    <path d="M28,43a2,2,0,0,1-1.41-3.41L42.19,24,26.62,8.43A2,2,0,0,1,29.44,5.6l17,17A2,2,0,0,1,47,24a2.07,2.07,0,0,1-.59,1.44l-17,17A2,2,0,0,1,28,43Z" fill="#3ec2bd"/>
                				</svg> 
                			</a>
                			
                		</div>
                		
                	<?php endif; ?>
                
                </header>
                
                <?php  if( $header['_dlr_logo'] !== false && $header['_dlr_logo'] !== null && $header['_dlr_logo'] !== '' ): ?>
                <a href="<?= bloginfo('url'); ?>">
                	<img class="skip-lazy" src="<?php echo esc_attr($header['_dlr_logo']); ?>">
                </a>
                <?php endif; ?>
            
            </div>