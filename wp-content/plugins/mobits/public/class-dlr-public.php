<?php
class Dlr_Public {
    
    private $wpdb;
    private $table;
    
    private $recovery;

	public function __construct( $plugin_name, $version ) 
	{
		global $wpdb, $charset_collate;
		$this->wpdb = $wpdb;
		$this->table = $wpdb->prefix . "dlr_activation";
		
		$this->recovery = home_url() .'/'. get_option('_dlr_page_slug', 'dlr-login-register') . '?type=recovery';
	}
	
	public function dlr_init () 
	{
	    if(!session_id()) {
            session_start();
        }
        
	    add_rewrite_endpoint( get_option('_dlr_page_slug', 'dlr-login-register'), EP_ROOT );
	        
	}
	
	public function dlr_query_vars ( $vars )
	{
	    $vars[] = get_option('_dlr_page_slug', 'dlr-login-register');
        return $vars;
	}
	
	public function dlr_go_mobits_shortcode($atts){}
	
	
	public function dlr_template_include($template) 
	{
	    global $wp_query;

	    if( array_key_exists ( get_option('_dlr_page_slug', 'dlr-login-register') , $wp_query->query_vars ) ) 
	    {
            return DLR_BASE . '/public/partials/dlr_View.php';
        }
        
        if( get_option('_dlr_login_force_all', '0') == 1 && !is_admin() && ! array_key_exists ( get_option('_dlr_page_slug', 'dlr-login-register') , $wp_query->query_vars ) ) 
        {
            return DLR_BASE . '/public/partials/dlr_View.php';
        }
        
        return $template;
	}
	
	public function dlr_wp()
	{
	    global $wp_query;
	    
	    if( get_option('_dlr_login_force_all', '0') == 1 && !is_admin() && ! array_key_exists ( get_option('_dlr_page_slug', 'dlr-login-register') , $wp_query->query_vars ) ) 
        {
            wp_redirect(home_url() .'/'. get_option('_dlr_page_slug', 'dlr-login-register'));
            exit;
        }
	}
	
	public function dlr_main_init () 
	{
	    if(!session_id()) {
            session_start();
        }
        
	    add_rewrite_endpoint( get_option('_dlr_page_slug', 'dlr-login-register'), EP_ROOT );
	    
	    $this->dlr_controller();
	    
	    if( !is_user_logged_in() && $GLOBALS['pagenow'] === 'wp-login.php' && get_option('_dlr_admin_login_redirect', 0) == 1 )
	    {
            wp_redirect(home_url() .'/'. get_option('_dlr_page_slug', 'dlr-login-register') . '?back='.home_url().'/wp-admin');
            exit;
        }
	}
	
	public function dlr_controller () 
	{
	    if( isset($_POST['dlr-login']) ) {
	        $this->dlr_login_request();
	    }
	    elseif( isset($_POST['dlr-register']) ) {
	        $this->dlr_register_request();
	    }
	    elseif( isset($_POST['dlr-recovery']) ) {
	        $this->dlr_recovery_request();
	    }
	    elseif( isset($_POST['dlr-checkCode']) ) {
	        $this->dlr_checkCode_request();
	    }
	    elseif( isset($_POST['dlr-sendAgain']) ) {
	        $this->dlr_repeat_request();
	    }
	}
	
	public function dlr_login_request() 
	{
	    $mobile = sanitize_text_field( $this->convert( $_POST['loginMobile'] ) );
        $code = rand(1000, 9999);
	    
	    $_SESSION['dlr_mobile'] = $mobile;
	    $_SESSION['dlr_status'] = 'login';
	    
	    if( get_option('_dlr_register_in_login_form') != 1 )
	    {
	        $mobile2 = substr($mobile, 1);
	    
    	    $table = $this->wpdb->prefix . 'users';
    	    $user  = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $table WHERE user_login IN (%d,%s)", $mobile, $mobile2));
    	    
    	    $digits_user = false;
    	    if( get_option('_dlr_support_digits', 0) == 1 )
    	    {
    	        $users = get_users(
    		            array(
            		        'meta_query'=> array(
            		            'relation'  => 'or',
            		            array(
                                    'key' => 'digits_phone_no',
                                    'value' => $mobile2
                                ),
                                array(
                                    'key' => 'digits_phone',
                                    'value' => '+98'.$mobile2
                                )
            		        )
        		        )
    		    );
    		    
    		    $digits_user = !isset($users[0]) ? false : true;
    	    }
    	    
    	    if( $user==null && !$digits_user ) 
    	    {
    	        wp_redirect(home_url() .'/'. get_option('_dlr_page_slug', 'dlr-login-register') . '?status=0');
                exit;
    	    }
	    }
    	    
    	$this->create_user_code($code, $mobile);
	}
	
	public function dlr_recovery_request() 
	{
		
	    $_SESSION['dlr_mobile'] = sanitize_text_field( $this->convert( $_POST['mobile'] ) );
	    $_SESSION['dlr_username'] = sanitize_text_field( $_POST['username'] );
	    $_SESSION['dlr_status'] = 'recovery';
	    
	    $check = wp_authenticate_username_password( NULL, $_SESSION['dlr_username'], sanitize_text_field( $_POST['password'] ) );
	    
	    if( is_wp_error( $check ) ) 
	    {
	        $_SESSION['wrongUP'] = true;
	        wp_redirect($this->recovery);
	        exit;
	    }
    	    
    	$this->create_user_code(rand(1000, 9999), $_SESSION['dlr_mobile']);
	}
	
	public function create_user_code($code, $mobile) 
	{
	    
        $now = time();
	    $check = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM $this->table WHERE mobile=%d", $mobile ) );

	    if($check!==NULL)
	    {
	        if( (int)$now-(int)$check->time > (int)get_option('_dlr_resend_code_time', 120) )
	        {
	            $this->wpdb->update( $this->table, array(
                    'code'      => $code,
                    'time'      => time()
                ), array(
                    'mobile' => $mobile
                ));
                $this->dlr_send_sms($code, $mobile);
	        }
	    }
	    else {
	        $this->wpdb->insert( $this->table, array(
                'code'      => $code,
                'mobile'    => $mobile,
                'time'      => time()
            ));
            $this->dlr_send_sms($code, $mobile);
	    }
	}
	
	public function dlr_repeat_request() 
	{
	    $mobile = $_SESSION['dlr_mobile'];
    	$code = rand(1000, 9999);
    
    	$this->dlr_update_user_code($code, $mobile);
    	
    	$this->dlr_send_sms($code, $mobile);
	}
	
	public function dlr_rest_api_init() 
	{
	    register_rest_route( 'api', '/sendSmsMelliPayamak', array(
            'methods' => 'post',
            'callback' => [$this, 'send_mellipayamak_rest_callback'],
			'permission_callback'	=> '__return_true'
        ));
	}
	
	public function dlr_register_request() 
	{
	    $name = sanitize_text_field( $_POST['regName'] );
    	$mobile = sanitize_text_field( $this->convert($_POST['regMobile']) );

		$_SESSION['dlr_mobile'] = $mobile;
        $_SESSION['dlr_first_name'] = $name;
        $_SESSION['dlr_status'] = 'register';

		do_action('dlr_before_register_handle');

        $code = rand(1000, 9999);
        
        $this->create_user_code($code, $mobile);
	}
	
	public function dlr_update_user_code($code, $mobile) 
	{
        $this->wpdb->update( $this->table, array( 'mobile'=> $mobile, 'code'  => $code ), array( 'mobile'    => $mobile ) );
	}
	
	public function dlr_checkCode_request () 
	{
	    $code = sanitize_text_field($_POST['userCode']);
    	$mobile = $_SESSION['dlr_mobile'];
    	
    	if( ! $this->check_user($code, $mobile) ) 
    	{
    	    $_SESSION['wrongCode'] = true;
    	}
    	else 
    	{
    	    if( isset($_SESSION['dlr_status']) && $_SESSION['dlr_status'] == 'recovery') 
    	    {
    	        $user = get_user_by( 'login', $_SESSION['dlr_username'] );

    	        $this->wpdb->update($this->wpdb->users, array('user_login' => $mobile), array('ID' => $user->ID));
    	        
    	        if( get_option('_dlr_support_woocommerce', 0) == 1 && get_option('_dlr_save_mobile_in_woocommerce', 0) == 1 ) 
        		{
        		    update_user_meta( $user->ID, 'billing_phone', $mobile );
        		    update_user_meta( $user->ID, 'shipping_phone', $mobile );
        		}
        		
        		update_user_meta( $user->ID, 'mobits_mobile_number', '+98'.$mobile );
    	    }
    	    else 
    	    {
    	        $create = $this->create_user($mobile);
    	    }
    	    
    	    if($create || $user)
    	    {
    	        $this->login($mobile);
    		    $this->delete_user_code($code, $mobile);
    		    
    		    if( get_option('_dlr_support_woocommerce', 0) == 1 && isset($_GET['back']) && $_GET['back']=='checkout' )
    		    {
    		        $home = home_url();
    		        wp_redirect( $home . '/checkout' );
					exit;
    		    }
    		    elseif( isset($_GET['back']) )
    		    {
    		        wp_redirect( $_GET['back'] );
    		        exit;
    		    }
    		    else {
    		        wp_redirect( get_option('_dlr_redirect_url', home_url() ) );
					exit;
    		    }
    		    
    	    }
    	    else {
    	        $_SESSION['userExists'] = true;
    	    }
    	    
    		
    	}
	}
	
	private function create_user ($mobile) 
	{
	    $mobile2 = substr($mobile, 1);
	    
	    $table = $this->wpdb->prefix . 'users';
	    $user = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $table WHERE user_login IN (%d,%s)", $mobile, $mobile2));
	    
	    if( $user !== null ) return true;
	    
	    if( get_option('_dlr_support_digits', 0) == 1 )
	    {
	        $user = username_exists( '0'.$mobile );
	        if( $user ) return true;
	    
	        $users = get_users(
		            array(
        		        'meta_query'=> array(
        		            'relation'  => 'or',
        		            array(
                                'key' => 'digits_phone_no',
                                'value' => $mobile2
                            ),
                            array(
                                'key' => 'digits_phone',
                                'value' => '+98'.$mobile2
                            )
        		        )
    		        )
		    );
		    
            if( isset($users[0]) ) return true;
	    }
	    
        if($_SESSION['dlr_status'] == 'login') 
        {
	        $userdata = array(
    			'user_login' 		=>  $mobile,
    			'user_pass'			=>  wp_generate_password( 8, true)
    		);
        }
		else if( $_SESSION['dlr_status'] == 'register' )
		{
		    $userdata = array(
    			'user_login' 		=>  $mobile,
    			'user_pass'			=>  wp_generate_password( 8, true),
    			'first_name'		=>  $_SESSION['dlr_first_name']
    		);
		}
		
		$userId = wp_insert_user( $userdata );
		
		if( get_option('_dlr_support_woocommerce', 0) == 1  ) 
		{
		    if( get_option('_dlr_save_mobile_in_woocommerce', 0) == 1 )
		    {
		        update_user_meta( $userId, 'billing_phone', $mobile );
		        update_user_meta( $userId, 'shipping_phone', $mobile );
		    }
		    
		    if( get_option('_dlr_save_name_in_woocommerce', 0) == 1 && isset($_SESSION['dlr_first_name']) )
		    {
		        update_user_meta( $userId, 'billing_first_name', $_SESSION['dlr_first_name'] );
		        update_user_meta( $userId, 'shipping_first_name', $_SESSION['dlr_first_name'] );
		    }
		}
		
		update_user_meta( $userId, 'mobits_mobile_number', '+98'.$mobile );

		do_action('dlr_after_create_user', $userId);
        
        return true;
	}
	
	private function login ($mobile)
	{
	    $table = $this->wpdb->prefix . 'users';
	    $user = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $table WHERE user_login IN (%d,%s)", $mobile, $mobile2));
		
		if( !$user && get_option('_dlr_support_digits', 0) == 1 )
		{
		    $table = $this->wpdb->prefix . 'users';
	        $user = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $table WHERE user_login IN (%d,%s)", $mobile, $mobile2));
		    
		    if($user == null)
		    {
		        $user = reset( 
    		        get_users(
    		            array(
            		        'meta_query'=> array(
            		            'relation'  => 'or',
            		            array(
                                    'key' => 'digits_phone_no',
                                    'value' => $mobile
                                ),
                                array(
                                    'key' => 'digits_phone',
                                    'value' => '+98'.$mobile
                                )
            		        )
        		        )
    		        )
    		    );
		    }
		    
		}

		wp_clear_auth_cookie();
		wp_set_current_user($user->ID);
		wp_set_auth_cookie($user->ID, true);
	}
	
	private function check_user($code, $mobile) 
	{
	    $check = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM $this->table WHERE mobile=%d AND code=%s", $mobile, $code ) );
	    return ($check==NULL) ? false : true;
	}
	
	private function delete_user_code($code, $mobile) 
	{
        $this->wpdb->delete(
            $this->table, array(
                'mobile'=> $mobile,
                'code'  => $code
        ));
	}
	
	private function dlr_send_sms($code, $mobile) 
	{
	    $now = time();
	    $check = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM $this->table WHERE mobile=%d", $mobile ) );
	    
	    $dlr_sms_service = get_option('_dlr_sms_service', 'melipayamak' );
	    
	    switch( $dlr_sms_service ) {
	        case 'melipayamak':
	            $this->send_mellipayamak($code, $mobile);
	            break;
	        case 'smsir':
	            $this->dlr_send_sms_sms_ir($code, $mobile);
	            break;
	        case 'ippanel':
	            $this->dlr_send_sms_ippanel($code, $mobile);
	            break;
	    }
	}
	
	public function send_mellipayamak_rest_callback($data) 
	{
	    $params = $data->get_params();
	    
	    $code   = $params['code'];
	    $mobile = '0'.$params['mobile'];
	    $bodyId = get_option( '_dlr_sms_melipayamak_theme', 0 );
    	$username = get_option( '_dlr_sms_melipayamak_username', 0 );
    	$password = get_option( '_dlr_sms_melipayamak_password', 0 );
	    
	    $ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL,"http://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber");
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, 'username='.$username.'&password='.$password.'&to='.$mobile.'&bodyId='.$bodyId.'&text='.$code);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$server_output = curl_exec($ch);
    	curl_close ($ch);
	}
	
	private function send_mellipayamak($code, $mobile) 
	{
	    ?>
	    <script>
    	    var xhr = new XMLHttpRequest();
        	xhr.open('Post', '<?= home_url(); ?>/wp-json/api/sendSmsMelliPayamak');
        	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        	xhr.onload = function() {};
        	xhr.send(encodeURI('mobile='+<?= $mobile; ?>+'&code='+<?= $code; ?>));
    	</script>
	    <?php
	}
	
	public function dlr_send_sms_sms_ir($code, $mobile) 
	{
	    require dirname(__FILE__) . '/libs/smsir.php';
	    
        date_default_timezone_set("Asia/Tehran");
        
        $APIKey = get_option('_dlr_sms_smsir_secretKey', '' );
        $SecretKey = get_option('_dlr_sms_smsir_appKey', '' );
        
        $APIURL = "https://ws.sms.ir/";
        
        $data = array(
            "ParameterArray" => array(
                array(
                    "Parameter" => "code",
                    "ParameterValue" => $code
                )
            ),
            "Mobile" => $mobile,
            "TemplateId" => get_option('_dlr_sms_smsir_theme', '' )
        );
        
        $SmsIR_UltraFastSend = new SmsIR_UltraFastSend($APIKey, $SecretKey, $APIURL);
        $UltraFastSend = $SmsIR_UltraFastSend->ultraFastSend($data);
	}
	
	private function convert( $string ) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];
    
        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);
        
        return $englishNumbersOnly;
    }
    
    public function dlr_send_sms_ippanel($code, $mobile)
    {
        $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
        $user = get_option('_dlr_sms_ippanel_username', '' );
        $pass = get_option('_dlr_sms_ippanel_password', '' );
        $fromNum = get_option('_dlr_sms_ippanel_from', '' );
        $toNum = array($mobile);
        $pattern_code = get_option('_dlr_sms_ippanel_theme', '' );
        $input_data = array(
         "verification-code" => $code
        );
        $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
    }
    
    public function go_mobits_shortcode_handler()
    {
        global $post;
		$regex = get_shortcode_regex();
		if(!isset($post->post_content)) return true;
        preg_match_all('/'.$regex.'/',$post->post_content,$matches);
        
        if( !empty($matches[2]) && in_array('go_mobits', $matches[2]) && !is_user_logged_in() )
        {
            global $wp;
            $key = array_search('go_mobits', $matches[2]);
            $back = $matches[3][$key] !== '' ? '?'.trim($matches[3][$key]) : '?back='.home_url( $wp->request );
            wp_redirect(home_url() .'/'. get_option('_dlr_page_slug', 'dlr-login-register') . $back);
            exit;
        }
    }
    
    public function dlr_template_redirect() 
    {
		global $wp_query;
		
		$this->go_mobits_shortcode_handler();
	    
	    if(isset($wp_query->query_vars['customer-logout']))
	    {
	        wp_logout();
    		wp_redirect( get_option('_dlr_redirect_logout', home_url()) );
    		exit();
	    }
        
        if( get_option('_dlr_support_woocommerce', 0) == 1 )
        {
            if( class_exists( 'woocommerce' ) && is_account_page() && get_option('_dlr_redirect_my_account', '0') == 1 && !is_user_logged_in() )
            { 
        		wp_redirect(home_url() .'/'. get_option('_dlr_page_slug', 'dlr-login-register'));
        		exit;
            }
            
            $pageid = get_option( 'woocommerce_checkout_page_id' );
        	if(!is_user_logged_in() && is_page($pageid) && get_option('_dlr_redirect_checkout', '0') == 1)
        	{
        		wp_redirect(home_url() .'/'. get_option('_dlr_page_slug', 'dlr-login-register') . '/?back=checkout');
        		exit;
        	}
        }
        
        
    }
    
    public function dlr_bulk_actions_users($bulk_actions)
    {
        $bulk_actions['_dlr_export_csv'] = __('Excel output of users', 'dlr');
	    return $bulk_actions;
    }
    
    public function dlr_handle_bulk_actions_users($redirect, $action, $object_ids)
    {
        if ($action == '_dlr_export_csv') 
        {
    		$users = get_users(array(
    		    'include' =>  $object_ids,
    		    'fields'  => array('ID' ,'user_login')
    		));
    		
    		$final = [];
    		$FileName = 'users.csv';
    		$fp = fopen($FileName, 'w');
    		
    		foreach($users as $user) 
    		{
    		    $row = [
    		        'mobile' => $user->user_login,
    		        'name' => get_user_meta($user->ID, 'first_name', true),
    		        'last' => get_user_meta($user->ID, 'last_name', true)
    		    ];
    		    
    		    fputcsv($fp, $row);
    		}
    		
            fclose($fp);
            header("Location: $FileName");
    	}
    }
}