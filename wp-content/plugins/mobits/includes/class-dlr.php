<?php

class Dlr {

	protected $loader;

	protected $plugin_name;

	protected $version;

	public function __construct() {
		if ( defined( 'DLR_VERSION' ) ) {
			$this->version = DLR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'dlr';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dlr-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dlr-i18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dlr-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dlr-public.php';

		$this->loader = new Dlr_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new Dlr_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Dlr_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'dlr_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'dlr_init' );
		
		$this->loader->add_action('user_profile_update_errors', $plugin_admin, 'dlr_user_profile_update_errors', 10, 3 );
		$this->loader->add_action('user_new_form', $plugin_admin, 'dlr_remove_require_email', 10, 1);
        $this->loader->add_action('show_user_profile', $plugin_admin, 'dlr_remove_require_email', 10, 1);
        $this->loader->add_action('edit_user_profile', $plugin_admin, 'dlr_remove_require_email', 10, 1);

	}

	private function define_public_hooks() {

		$plugin_public = new Dlr_Public( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_filter( 'query_vars', $plugin_public, 'dlr_query_vars' );
		$this->loader->add_filter( 'template_include', $plugin_public, 'dlr_template_include', 99 );
		$this->loader->add_action( 'init', $plugin_public, 'dlr_init' );
		$this->loader->add_action( 'rest_api_init', $plugin_public, 'dlr_rest_api_init' );
		$this->loader->add_action( 'template_redirect', $plugin_public, 'dlr_template_redirect' );
		$this->loader->add_action( 'wp', $plugin_public, 'dlr_wp' );
		$this->loader->add_shortcode( 'go_mobits', $plugin_public, 'dlr_go_mobits_shortcode' );
		
		! is_admin() and $this->loader->add_action( 'init', $plugin_public, 'dlr_main_init' );
		
		if( get_option('_dlr_export_csv', '0') == 1 ){
		    $this->loader->add_filter( 'bulk_actions-users', $plugin_public, 'dlr_bulk_actions_users' );
		    $this->loader->add_filter('handle_bulk_actions-users', $plugin_public , 'dlr_handle_bulk_actions_users', 10, 3);
		}
	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
