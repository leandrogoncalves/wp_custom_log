<?php
/**
 * @link              https://github.com:leandrogoncalves/wp_custom_log
 * @since             1.0.0
 * @package           wp_custom_log
 *
 * @wordpress-plugin
 * Plugin Name:       WP Custom Log
 * Plugin URI:        https://github.com:leandrogoncalves/wp_custom_log
 * Description:       Wordpress Plugin to Implement a Custom Log Writer
 * Version:           1.0.0
 * Author:            Leandro Gonçavlves <contato.leandrogoncalves@gmail.com>
 * Author URI:        https://github.com/leandrogoncalves
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       wp-custom-log
 * Domain Path:       /languages
 */
if ( ! defined( 'WPINC' ) ) {
    die('WP precisa ser inicializado');
}
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'src/WPCustomLog.php';
new VcCustomCarousel();
