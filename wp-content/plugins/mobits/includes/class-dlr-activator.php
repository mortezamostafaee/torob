<?php

class Dlr_Activator {

	public static function activate() 
	{
	    global $wpdb, $charset_collate;
        $table = $wpdb->prefix . "dlr_activation";
         
        $query = "CREATE TABLE IF NOT EXISTS $table (
        id int(11) NOT NULL AUTO_INCREMENT,
        code varchar(255) CHARACTER SET utf8 NOT NULL,
        mobile varchar(255) CHARACTER SET utf8 NOT NULL,
        time varchar(255) CHARACTER SET utf8 NOT NULL,
        PRIMARY KEY (id)
        ) $charset_collate;";
         
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $query );
        
        $options = array(
            '_dlr_login_status'     => 1,
            '_dlr_register_status'  => 1,
            '_dlr_page_slug'        => 'login-register',
            '_dlr_redirect_url'     => home_url(),
            '_dlr_auto_confirm'     => 1,
            '_dlr_color'            => '#9199e4',
            '_dlr_color_tab'        => '#9199e4',
            '_dlr_sms_service'      => 'ippanel',
            '_dlr_redirect_logout'  => home_url(),
            '_dlr_background_image' => home_url() . '/wp-content/plugins/mobits/public/images/bg.jpg',
            '_dlr_design_type'      => 'modern',
            '_dlr_button_image'     => 1,
            '_dlr_logo'             => home_url() . '/wp-content/plugins/mobits/public/images/mobits.png',
            '_dlr_resend_code_time' => 120,
        );
        
        foreach($options as $key=>$value) 
        {
            if ( get_option($key, 11111) == 11111 ) 
            {
                add_option($key, $value);
            }
        }
        
	    add_rewrite_endpoint( get_option('_dlr_page_slug', 'login-register'), EP_ROOT );
        flush_rewrite_rules();
	}

}
