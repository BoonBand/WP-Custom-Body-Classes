<?php
/*
Plugin Name: Custom Body Classes by Boon.Band
Plugin URI: https://boon.band/
Description: A powerful and professional WordPress plugin for adding custom body classes to your pages based on various conditions, developed by Boon.Band.
Version: 1.0.0
Author: Boon.Band
Author URI: https://boon.band/
License: GPL v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Text Domain: wp-custom-body-classes-by-boon-band
Domain Path: /languages

*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
// Load helper functions
require_once plugin_dir_path(__FILE__) . 'includes/helper-functions.php';

// Load plugin textdomain
add_action('plugins_loaded', function () {
    load_plugin_textdomain('wp-custom-body-classes-by-boon-band', false, basename(dirname(__FILE__)) . '/languages');
});

// Register admin settings page
add_action('admin_menu', 'boonband_custom_body_classes_register_settings_page');
function boonband_custom_body_classes_register_settings_page()
{
    add_options_page(
        __('Custom Body Classes', 'wp-custom-body-classes-by-boon-band'),
        __('Custom Body Classes', 'wp-custom-body-classes-by-boon-band'),
        'manage_options',
        'wp-custom-body-classes-by-boon-band',
        'boonband_custom_body_classes_settings_page'
    );
}

// Admin settings page
function boonband_custom_body_classes_settings_page()
{
// Enqueue necessary scripts and styles
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('wp-custom-body-classes-by-boon-band-script', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), '1.0.0', true);
    wp_enqueue_style('wp-custom-body-classes-by-boon-band-style', plugin_dir_url(__FILE__) . 'css/admin.css', array(), '1.0.0');

    // Include the admin settings template
    include_once plugin_dir_path(__FILE__) . 'templates/admin-settings.php';
}

// Enqueue admin scripts and styles
add_action('admin_enqueue_scripts', 'boonband_custom_body_classes_admin_scripts');
function boonband_custom_body_classes_admin_scripts($hook)
{
    if ($hook !== 'settings_page_wp-custom-body-classes-by-boon-band') {
        return;
    }

    wp_enqueue_style(
        'wp-custom-body-classes-by-boon-band-admin',
        plugin_dir_url(__FILE__) . 'admin-styles.css',
        array(),
        '1.0.0',
        'all'
    );

    wp_enqueue_script(
        'wp-custom-body-classes-by-boon-band-admin',
        plugin_dir_url(__FILE__) . 'admin.js',
        array('jquery', 'jquery-ui-sortable'),
        '1.0.0',
        true
    );
}


// Register and store plugin settings
add_action('admin_init', 'boonband_custom_body_classes_register_settings');
function boonband_custom_body_classes_register_settings()
{
    register_setting('boonband_custom_body_classes_settings_group', 'boonband_custom_body_classes_rules');
}

// Add custom body classes based on rules
add_filter('body_class', 'boonband_custom_body_classes_add_classes');
function boonband_custom_body_classes_add_classes($classes)
{
    // Include necessary helper functions
    include_once plugin_dir_path(__FILE__) . 'includes/helper-functions.php';
    // Get the stored rules
    $rules = get_option('boonband_custom_body_classes_rules');

    if (!empty($rules)) {
        foreach ($rules as $rule) {
            if (boonband_custom_body_classes_check_condition($rule)) {
                $class_names = explode(" ", $rule['class_name']); // Split input value into separate classes
                $classes = array_merge($classes, $class_names); // Merge the separate classes into the existing classes array
            }
        }
    }

    return $classes;

}

// Load plugin textdomain
add_action('plugins_loaded', 'boonband_custom_body_classes_load_textdomain');
function boonband_custom_body_classes_load_textdomain()
{
    // Load the plugin textdomain for translation
    load_plugin_textdomain('wp-custom-body-classes-by-boon-band', false, dirname(plugin_basename(__FILE__)) . '/languages');
}


// Ajax handler for updating condition value options
add_action('wp_ajax_boonband_custom_body_classes_update_condition_value_options', 'boonband_custom_body_classes_update_condition_value_options');
function boonband_custom_body_classes_update_condition_value_options()
{
    if (!isset($_POST['condition'])) {
        wp_die();
    }

    $condition = sanitize_text_field($_POST['condition']);
    echo boonband_custom_body_classes_get_condition_value_options($condition);

    wp_die();
}
