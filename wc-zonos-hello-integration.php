<?php
   /*
   Plugin Name: EP Zonos Integration for WooCommerce
   description: Plugin to show prices in the user location currency using Zonos Hello.
   Version: 0.0.1
   Author: Eri Panci
   Author URI: http://eripanci.com
   License: GPL2
   */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('ZONOS_PLUGIN_DIR')) {
    define('ZONOS_PLUGIN_DIR', plugin_dir_url(__FILE__));
}

require_once 'classes/class-zonos-hello-settings.php';
require_once 'classes/class-zonos-hello-scripts.php';

class ZonosHelloWC {
    /**
     * Class Instance
     *
     * @var null
     */
    private static $instance = null;

     /**
     * ZonosHelloWC constructor.
     */
    private function __construct()
    {
        $this->init();
    }

    /**
     * Init function
     */
    public function init()
    {
        new ZonosHelloSettings();
        new ZonosHelloScripts();
    }

    /**
     * Get singleton instance
     */
    public static function get()
    {

        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;

    }
}

/**
 * @return null|ZonosHelloWC
 */
function initZonosHelloWC()
{
    return ZonosHelloWC::get();
}

initZonosHelloWC();

?>