<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://depcore.pl
 * @since      1.0.0
 *
 * @package    Depcore_Greenfox
 * @subpackage Depcore_Greenfox/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Depcore_Greenfox
 * @subpackage Depcore_Greenfox/includes
 * @author     Depcore <biuro@depcore.pl>
 */
class Depcore_Greenfox_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'depcore-greenfox',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
