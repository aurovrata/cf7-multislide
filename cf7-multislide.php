<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://syllogic.in
 * @since             1.0.0
 * @package           Cf7_Multislide
 *
 * @wordpress-plugin
 * Plugin Name:       Contact Form 7 Multi-slide Module
 * Plugin URI:        http://wordpress.syllogic.in
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.1.0
 * Author:            Aurovrata V.
 * Author URI:        http://syllogic.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cf7-multislide
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cf7-multislide-activator.php
 */
function activate_cf7_multislide() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cf7-multislide-activator.php';
	Cf7_Multislide_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cf7-multislide-deactivator.php
 */
function deactivate_cf7_multislide() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cf7-multislide-deactivator.php';
	Cf7_Multislide_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cf7_multislide' );
register_deactivation_hook( __FILE__, 'deactivate_cf7_multislide' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cf7-multislide.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cf7_multislide() {

	$plugin = new Cf7_Multislide();
	$plugin->run();

}
run_cf7_multislide();
