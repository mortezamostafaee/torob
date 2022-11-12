<?php

function elementor_torob_addon() {

    // Load plugin file
    require_once(__DIR__ . '/includes/plugin.php');

    // Run the plugin
    \Elementor_torob_commercial_rows_Widget\Plugin::instance();

}
add_action( 'after_setup_theme', 'elementor_torob_addon' );