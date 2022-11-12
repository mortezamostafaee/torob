<?php

	/*
		Plugin Name: Aparat
		Plugin URI: https://wordpress.org/plugins/aparat/
		Description: نمایش ریسپانسیو ویدئوهای آپارات در مطالب توسط شورت‌کد ...
		Version: 1.7.1
		Author: Nima Saberi
		Author URI: http://uxdev.ir
		
	*/

	// [aparat id='iybdS']
	// [aparat id='iybdS' width='600' height='450' style='margin: 15px; padding: 7px']
	// https://www.aparat.com/v/iybdS

	function aparat($atts) {
		//$atts = str_replace("’", "", $atts);
		extract( shortcode_atts( array(
			'id' => '',
			'width' => '100%',
			'height' => 450,
			'style' => 'margin: 15px 1px 10px 1px;'
		), $atts ) );
		$id = str_replace("’", "", $id);
		return "<center style='{$style}'><iframe src='".(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http')."://www.aparat.com/video/video/embed/videohash/{$id}/vt/frame' width='{$width}' height='{$height}' allowfullscreen='true' style='border:none!important'></iframe></center>";
	}
	add_shortcode( 'aparat', 'aparat' );

	function aparat_editor_btn($buttons) {
		array_push($buttons, "separator", "aparat_shortcode");
		return $buttons;
	}
	add_filter('mce_buttons', 'aparat_editor_btn', 0);

	function aparat_shortcode_register($plugin_array)	{
		$plugin_array['aparat_shortcode'] = plugins_url('tinyMCE/editor_plugin.js?v1.6', __FILE__);
		return $plugin_array;
	}
	add_filter('mce_external_plugins', "aparat_shortcode_register");
	
	function uxdev_admin_page() {
		echo '<div class="wrap">'.
			'<h2>افزونه آپارت</h2>'.
			'<hr>'.
			'افزونه غیررسمی برای وب‌سایت اشتراک‌گذاری ویدیوی aparat.com، که امکان قراردادن ویدیوها در ادیتور وردپرس و نمایش ریسپانسیو آن‌را در پست‌ها فراهم می‌کند. این افزونه توسط تیم <a href="http://uxdev.ir" target="_blank"><b>uxDev.ir</b></a> برنامه‌نویسی شده و به رایگان در مخزن وردپرس قرار گرفته است.'.
			'<br><br><br>* شورت‌‌کد پیشفرض :<br><pre dir="ltr" style="text-align: right;">[aparat id=\'iybdS\']</pre>'.
			'<br>* شورت‌کد با امکان شخصی‌سازی :<br><pre dir="ltr" style="text-align: right;">[aparat id=\'iybdS\' width=\'600\' height=\'450\' style=\'margin: 15px; padding: 7px\']</pre>'.
		'</div>';
	}
	
	if ( ! function_exists('register_uxdev_menu') ) {
		add_action('admin_menu', 'register_uxdev_menu');
		function register_uxdev_menu() {
			add_menu_page(
				'افزونه آپارات',
				'افزونه آپارات',
				'manage_options',
				'admin.php?page=uxdev',
				'uxdev_admin_page'
			);
			add_submenu_page(
				'admin.php?page=uxdev',
				'سایر پلاگین‌ها',
				'سایر پلاگین‌ها',
				'manage_options',
				'plugin-install.php?s=nipoto&tab=search&type=author',
				''
			);
			add_submenu_page(
				'admin.php?page=uxdev',
				'درباره ما',
				'درباره ما',
				'manage_options',
				'http://uxdev.ir',
				''
			);
		}
	}

	function video_embed_link( $id, $regex, $callback, $priority ) {
		$output = sprintf(
			"[aparat id='%s']",
			$id[1]
		);
		return apply_filters( 'aparat_embed', $output, $id, $regex, $callback, $priority );
	}
	function register_embed() {
		wp_embed_register_handler( 'aparat', '#^https?://(?:www)\.aparat\.com\/v\/(.*?)\/?$#i', 'video_embed_link' );
	}
	add_action( 'init', 'register_embed' );
	
?>