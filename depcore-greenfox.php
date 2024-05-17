<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://depcore.pl
 * @since             1.0.0
 * @package           Depcore_Greenfox
 *
 * @wordpress-plugin
 * Plugin Name:       Depcore GreenFox product addons
 * Plugin URI:        https://depcore.pl
 * Description:       Adding fields to products backend with shortcodes
 * Version:           1.0.0
 * Author:            Depcore
 * Author URI:        https://depcore.pl/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       depcore-greenfox
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DEPCORE_GREENFOX_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-depcore-greenfox-activator.php
 */
function activate_depcore_greenfox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-depcore-greenfox-activator.php';
	Depcore_Greenfox_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-depcore-greenfox-deactivator.php
 */
function deactivate_depcore_greenfox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-depcore-greenfox-deactivator.php';
	Depcore_Greenfox_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_depcore_greenfox' );
register_deactivation_hook( __FILE__, 'deactivate_depcore_greenfox' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-depcore-greenfox.php';

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_depcore_greenfox() {

	$plugin = new Depcore_Greenfox();
	$plugin->run();

}
run_depcore_greenfox();
