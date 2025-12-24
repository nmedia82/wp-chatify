<?php
/**
 * Plugin Name: WP-Chatify (za:meedia)
 * Description: AI-powered chat widget for WordPress websites using domain-specific tokens
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: wp-chatify
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

define('CHATIFY_VERSION', '1.0.0');
define('CHATIFY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CHATIFY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CHATIFY_API_BASE', 'https://ssut09j0y4.execute-api.us-east-1.amazonaws.com/dev/mala/ask/zm-site');

require_once CHATIFY_PLUGIN_PATH . 'includes/class-chatify-activator.php';
require_once CHATIFY_PLUGIN_PATH . 'includes/class-chatify-admin.php';
require_once CHATIFY_PLUGIN_PATH . 'includes/class-chatify-frontend.php';
require_once CHATIFY_PLUGIN_PATH . 'includes/class-chatify-api.php';

register_activation_hook(__FILE__, array('Chatify_Activator', 'activate'));
register_deactivation_hook(__FILE__, array('Chatify_Activator', 'deactivate'));

add_action('plugins_loaded', 'chatify_init');

function chatify_init() {
    if (is_admin()) {
        new Chatify_Admin();
    }
    
    // Always load frontend for AJAX
    new Chatify_Frontend();
}
