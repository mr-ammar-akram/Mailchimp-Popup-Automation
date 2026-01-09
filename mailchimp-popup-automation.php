<?php
/**
 * Plugin Name: Mailchimp Popup Automation
 * Description: Smart Mailchimp popup control with thank-you popup automation.
 * Version: 1.1.0
 * Author: Ammar Akram
 * License: MIT
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Mailchimp_Popup_Automation {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    public function add_settings_page() {
        add_options_page(
            'Mailchimp Popup Automation',
            'Mailchimp Popup Automation',
            'manage_options',
            'mailchimp-popup-automation',
            [ $this, 'settings_page_html' ]
        );
    }

    public function register_settings() {
        register_setting( 'mpa_settings', 'mpa_options' );

        add_settings_section(
            'mpa_main_section',
            'Popup Automation Settings',
            null,
            'mailchimp-popup-automation'
        );

        add_settings_field(
            'enable_subscription_popup',
            'Enable Subscription Popup Logic',
            [ $this, 'checkbox_field' ],
            'mailchimp-popup-automation',
            'mpa_main_section',
            [ 'key' => 'enable_subscription_popup' ]
        );

        add_settings_field(
            'enable_thankyou_popup',
            'Enable Thank-You Popup',
            [ $this, 'checkbox_field' ],
            'mailchimp-popup-automation',
            'mpa_main_section',
            [ 'key' => 'enable_thankyou_popup' ]
        );

        add_settings_field(
            'subscription_popup_id',
            'Subscription Popup ID',
            [ $this, 'text_field' ],
            'mailchimp-popup-automation',
            'mpa_main_section',
            [ 'key' => 'subscription_popup_id', 'placeholder' => 'spu-53' ]
        );
    }

    public function checkbox_field( $args ) {
        $options = get_option( 'mpa_options' );
        $key = $args['key'];
        ?>
        <input type="checkbox" name="mpa_options[<?php echo esc_attr( $key ); ?>]" value="1"
            <?php checked( $options[ $key ] ?? 0, 1 ); ?>>
        <?php
    }

    public function text_field( $args ) {
        $options = get_option( 'mpa_options' );
        $key = $args['key'];
        ?>
        <input type="text"
               name="mpa_options[<?php echo esc_attr( $key ); ?>]"
               value="<?php echo esc_attr( $options[ $key ] ?? '' ); ?>"
               placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>">
        <?php
    }

    public function settings_page_html() {
        ?>
        <div class="wrap">
            <h1>Mailchimp Popup Automation</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'mpa_settings' );
                do_settings_sections( 'mailchimp-popup-automation' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function enqueue_scripts() {
        $options = get_option( 'mpa_options' );

        wp_enqueue_script(
            'mailchimp-popup-automation',
            plugin_dir_url( __FILE__ ) . 'assets/popup-automation.js',
            [],
            '1.1.0',
            true
        );

        wp_localize_script(
            'mailchimp-popup-automation',
            'MPA_SETTINGS',
            [
                'enableSubscription' => ! empty( $options['enable_subscription_popup'] ),
                'enableThankYou'     => ! empty( $options['enable_thankyou_popup'] ),
                'popupId'            => $options['subscription_popup_id'] ?? ''
            ]
        );
    }
}

new Mailchimp_Popup_Automation();
