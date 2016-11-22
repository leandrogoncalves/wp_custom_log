<?php

if(!defined('ABSPATH')) die('Wordpress is required');

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WP_Masonry_Grid
 * @subpackage WP_Masonry_Grid/includes
 * @author     Leandro Goncalves <contato.Leandro Goncalves@gmail.com>
 */
class WPCustomLog
{
    const LEVEL_ERROR = 1,
          LEVEL_WARNING = 2,
          LEVEL_NOTICE = 3;
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;
    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * WPCustomLog constructor.
     */
    public function __construct() {
        if (version_compare(PHP_VERSION, '5.5.0', '<')) {
            wp_die(__("This plugin require the PHP version 5.5.0 or later ", 'grp_plugin'));
        }
        if(!WP_DEBUG || !WP_DEBUG_LOG){
            wp_die('Para que o log funcione é preciso que o debug esteja ligado');
        }

        $this->plugin_name = 'wp_custom_log';
        $this->version = '1.0.0';

    }

    public static function writer($text, $level = self::LEVEL_ERROR){
        try{
            $level_log = $backtrace = $now = null;
            $user_name = "Not user logged in";

            switch ($level){
                case self::LEVEL_ERROR:
                    $level_log = 'Error';
                    break;
                case self::LEVEL_WARNING:
                    $level_log = 'Warning';
                    break;
                case self::LEVEL_NOTICE:
                    $level_log = 'Notice';
                    break;
                default:
                    $level_log = 'Error';
                    break;
            }

            if(!function_exists('is_user_logged_in')) throw new Exception('Função is_user_logged_in não declarada');

            if(is_user_logged_in()){
                $user = get_current_user();
                if($user instanceof WP_User){
                    $user_name = $user->user_firstname;
                }
            }

            if(is_array($text) || is_object($text)){
                ob_start();
                print_r($text);
                $text = ob_get_clean();
            }

            $date = new DateTime();

            $now = $date->format('d/m/Y H:s:i');
            ob_start();
            print_r(debug_backtrace());
            $backtrace = ob_get_clean();

            $log_text = "[{$level_log} - {$now}] => {$text} | User: {$user_name} | back trace: {$backtrace} ";

            if(!function_exists('error_log')) throw new Exception('Função error_log não declarada');

            error_log($log_text);

        }catch (Exception $e){
            print_r($e->getMessage());
        }
    }

    public static function error($text){
        self::writer($text, self::LEVEL_ERROR);
    }

    public static function warning($text){
        self::writer($text, self::LEVEL_WARNING);
    }

    public static function notice($text){
        self::writer($text, self::LEVEL_NOTICE);
    }
}