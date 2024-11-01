<?php

if (!defined('ABSPATH')) {
  exit;
}

class ZonosHelloScripts {

  public function __construct() {
    $this->option = get_option('zonos_hello_options');
    
    if($this->option['api_key']) {
      add_action('wp_enqueue_scripts', [$this, 'zonosHelloScript']);
      add_action('wp_enqueue_scripts', [$this, 'zonosInitScript']);
    }

    if($this->isProductAddonsPluginActive()) {
      add_action('wp_enqueue_scripts', [$this, 'zonosAddonsScript']);
    }
  }

  public function isProductAddonsPluginActive() {
    $active_plugins = get_option( 'active_plugins', array() );
    foreach ( $active_plugins as $key => $active_plugin ) {
      if ( strstr( $active_plugin, '/woocommerce-product-addons.php' ) ) {
            return true;
      }
    }
  }

  public function zonosInitScript() {  
    wp_enqueue_script( 'zonos-hello-init-script', ZONOS_PLUGIN_DIR . 'scripts/init-zonos.js', array(), '1.0' );
    wp_add_inline_script( 'zonos-hello-init-script', 'var zHelloPriceSelector = "' . $this->option['price_selector'] . '"', 'before');
  }

  public function zonosHelloScript() {
    wp_enqueue_script( 'zhello-script', 'https://hello.zonos.com/hello.js?siteKey=' . $this->option['api_key'], array(), '0.0.1' );
  }

  public function zonosAddonsScript() {
    wp_enqueue_script( 'zonos-hello-addons-script', ZONOS_PLUGIN_DIR . 'scripts/addons-zonos.js', array(), '0.0.1' );
  }
}