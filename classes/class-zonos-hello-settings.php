<?php

if (!defined('ABSPATH')) {
  exit;
}

class ZonosHelloSettings {

  public function __construct() {
    add_action( 'admin_menu', [$this, 'zonosHelloAddSettingsPage'] );
    add_action( 'admin_init', [$this, 'zonosHelloRegisterSettings'] );
  }
  
  public function zonosHelloAddSettingsPage() {
    add_options_page( 'Zonos Hello for WooCommerce', 'Zonos Hello for WooCommerce Menu', 'manage_options', 'zonos-hello-settings', [$this, 'zonosHelloRenderSettingsPage'] );
  }

  public function zonosHelloRenderSettingsPage() {
    ?>
    <h2>Zonos Hello for WooCommerce'</h2>
    <form action="options.php" method="post">
        <?php 
        settings_fields( 'zonos_hello_options' );
        do_settings_sections( 'zonos_hello' ); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
    </form>
    <?php
  }

  public function zonosHelloRegisterSettings() {
    register_setting( 'zonos_hello_options', 'zonos_hello_options' );
    add_settings_section( 'api_settings', '', '', 'zonos_hello' );
    add_settings_section( 'price_selector_settings', '', '', 'zonos_hello' );

    add_settings_field( 'zonosHelloSettingsApiKey', 'API Key', [$this, 'zonosHelloSettingsApiKey'], 'zonos_hello', 'api_settings' );
    add_settings_field( 'zonosHelloSettingsPriceSelector', 'Price Changers', [$this, 'zonosHelloSettingsPriceSelector'], 'zonos_hello', 'price_selector_settings' );
  }
  
  public function zonosHelloSectionText() {
    echo '<p>Here you can set all the options for using the API</p>';
  }

  public function zonosHelloSettingsApiKey() {
    $options = get_option( 'zonos_hello_options' );
    $apiKey = isset($options['api_key']) ? $options['api_key'] : null;
    ?>
      <input style="width:400px;" id='zonosHelloSettingsApiKey' name='zonos_hello_options[api_key]' type='text' value='<?php echo esc_attr( $apiKey ) ?>' />
      <p><i><?php _e("API key taken from Zonos."); ?></i></p>
    <?php
  }

  public function zonosHelloSettingsPriceSelector() {
    $options = get_option( 'zonos_hello_options' );
    $priceSelector = isset($options['price_selector']) ? $options['price_selector'] : null;
    ?>
      <input style="width:400px;" id='zonosHelloSettingsPriceSelector' name='zonos_hello_options[price_selector]' type='text' placeholder="#pa_size, #pa_test" value='<?php echo esc_attr( $priceSelector ) ?>' />
      <p><i><?php _e("The ID or the class that wraps the product attributes selectors and/or addons selectors."); ?></i></p>
    <?php
  }
}