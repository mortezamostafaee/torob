<?php
class Dlr_Admin {

	private $plugin_name;

	private $version;
	
	public $settings_value = [];

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() 
	{
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dlr-admin.css', array(), $this->version, 'all' );
		
		if(is_rtl())
		    wp_enqueue_style( 'dlr-rtl-admin', plugin_dir_url( __FILE__ ) . 'css/dlr-rtl-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() 
	{
	    wp_enqueue_media();
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dlr-admin.js', array( 'jquery' ), $this->version, false );
	}
	
	public function dlr_admin_menu() 
	{
	    add_menu_page(
            __('Mobits' , 'dlr'),
            __('Mobits' , 'dlr'),
            'manage_options',
            'dlr-settings',
            [&$this, 'dlr_login_register_setting_callback'],
            'dashicons-smartphone',
            50
        );
	}
	
	public function dlr_login_register_setting_callback () 
	{
	    require DLR_BASE . '/admin/partials/dlr-settings.php';
	}
	
	public function dlr_init() 
	{
	    
	     if ( isset($_POST['dlr_submit']) ) {
	         
	        if( !isset($_GET['dlr_tab']) || $_GET['dlr_tab'] == 'functional' ){
	            $args = [
	                '_dlr_redirect_url',
	                '_dlr_redirect_logout',
	                '_dlr_login_status',
	                '_dlr_register_status',
	                '_dlr_page_slug',
	                '_dlr_auto_confirm',
	                '_dlr_recovery_status',
	                '_dlr_username_register',
	                '_dlr_login_force_all',
	                '_dlr_export_csv',
	                '_dlr_support_digits',
	                '_dlr_support_woocommerce',
	                '_dlr_admin_login_redirect',
	                '_dlr_register_in_login_form',
	                '_dlr_resend_code_time'
	            ];
	        }
	        elseif( !isset($_GET['dlr_tab']) || $_GET['dlr_tab'] == 'woocommerce' ){
	            $args = [
	                '_dlr_redirect_my_account',
	                '_dlr_redirect_checkout',
	                '_dlr_save_mobile_in_woocommerce',
	                '_dlr_save_name_in_woocommerce',
	                '_dlr_checkout_notif'
	            ];
	        }
	        elseif( !isset($_GET['dlr_tab']) || $_GET['dlr_tab'] == 'captcha' ){
	            $args = [
	                '_dlr_google_captcha_in_login_form',
	                '_dlr_google_captcha_in_register_form',
	                '_dlr_google_captcha_in_recovery_form',
	                '_dlr_google_recaptchav2_site_key'
	            ];
	        }
	        elseif ( isset($_GET['dlr_tab']) && $_GET['dlr_tab'] == 'design' ) {
	            $args = [
	                '_dlr_logo',
	                '_dlr_favicon',
	                '_dlr_background_image',
	                '_dlr_description',
	                '_dlr_color',
	                '_dlr_color_tab',
	                '_dlr_extra_style',
	                '_dlr_dark_mode_status',
	                '_dlr_design_type',
	                '_dlr_button_image'
	            ];
	        }
	        elseif ( isset($_GET['dlr_tab']) && $_GET['dlr_tab'] == 'sms' ) 
	        {
	            $args = [
	                '_dlr_sms_service',
	                '_dlr_sms_melipayamak_username',
	                '_dlr_sms_melipayamak_password',
	                '_dlr_sms_melipayamak_theme',
	                '_dlr_sms_smsir_secretKey',
	                '_dlr_sms_ippanel_username',
	                '_dlr_sms_ippanel_password',
	                '_dlr_sms_ippanel_from',
	                '_dlr_sms_ippanel_theme',
	                '_dlr_sms_smsir_appKey',
	                '_dlr_sms_smsir_theme'
	            ];
	        }
            
	        foreach( $args as $value )
	        {
	            if(isset($_POST[$value]))
	            {
	                update_option( $value, wp_kses_post($_POST[$value]) );
	            }else {
					update_option( $value, '0' );
				}
	            
	            if( $value == '_dlr_page_slug' ){
	                if ($_POST[$value] === "") {
	                    update_option( $value, 'dlr-login-register' );
	                }
	            }
	            
	        }
	        
	        flush_rewrite_rules();
	            
	    }
	}
	
	function dlr_user_profile_update_errors($errors, $update, $user) 
	{
        $errors->remove('empty_email');
    }
    
    function dlr_remove_require_email($form_type)
    {
        ?>
        <script type="text/javascript">
        jQuery('#email').closest('tr').removeClass('form-required').find('.description').remove();
        <?php if (isset($form_type) && $form_type === 'add-new-user') : ?>
        jQuery('#send_user_notification').removeAttr('checked');
        <?php endif; ?>
        </script>
        <?php
    }

}
