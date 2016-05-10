<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://syllogic.in
 * @since      1.0.0
 *
 * @package    Cf7_Multislide
 * @subpackage Cf7_Multislide/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cf7_Multislide
 * @subpackage Cf7_Multislide/includes
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7_Multislide_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cf7-multislide',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
