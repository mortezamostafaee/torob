<?php

/**
 * Plugin Name:       Mobits
 * Description:       Login and register with mobile for your wordpress website.
 * Version:           2.1
 * Author:            بیاوردپرس
 * Author URI:        https://biawp.ir
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dlr
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DLR_VERSION', '1.0.0' );
define( 'DLR_BASE', plugin_dir_path( __FILE__ ) );
define( 'DLR_BASE_URL', plugin_dir_url( __FILE__ ) );
define( 'DLR_BASE_PARTIALS', plugin_dir_path( __FILE__ ) . '/public/partials/partials/' );

require dirname(__FILE__) . '/includes/functions.php';

function activate_dlr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dlr-activator.php';
	Dlr_Activator::activate();
}

function deactivate_dlr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dlr-deactivator.php';
	Dlr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dlr' );
register_deactivation_hook( __FILE__, 'deactivate_dlr' );

require plugin_dir_path( __FILE__ ) . 'includes/class-dlr.php';

function run_dlr() {

	$plugin = new Dlr();
	$plugin->run();

}
run_dlr();
