<?php
class Chatify_Admin {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_chatify_test_api', array($this, 'test_api_connection'));
        add_action('wp_ajax_chatify_load_tuning', array($this, 'load_tuning'));
        add_action('wp_ajax_chatify_save_tuning', array($this, 'save_tuning'));
        add_action('wp_ajax_chatify_delete_tuning', array($this, 'delete_tuning'));
    }
    
    public function add_admin_menu() {
        add_options_page(
            'WP-Chatify Settings',
            'WP-Chatify',
            'manage_options',
            'wp-chatify',
            array($this, 'admin_page')
        );
    }
    
    public function register_settings() {
        register_setting('chatify_settings', 'chatify_domain_token');
        register_setting('chatify_settings', 'chatify_widget_position');
        register_setting('chatify_settings', 'chatify_primary_color');
        register_setting('chatify_settings', 'chatify_secondary_color');
        register_setting('chatify_settings', 'chatify_text_color');
        register_setting('chatify_settings', 'chatify_widget_size');
        register_setting('chatify_settings', 'chatify_welcome_message');
        register_setting('chatify_settings', 'chatify_enabled');
        register_setting('chatify_settings', 'chatify_admin_only');
        register_setting('chatify_settings', 'chatify_show_homepage');
        register_setting('chatify_settings', 'chatify_show_posts');
        register_setting('chatify_settings', 'chatify_show_pages');
        register_setting('chatify_settings', 'chatify_auto_open');
        register_setting('chatify_settings', 'chatify_auto_open_delay');
    }
    
    public function admin_page() {
        include CHATIFY_PLUGIN_PATH . 'templates/admin-settings.php';
    }
    
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'settings_page_wp-chatify') {
            return;
        }
        
        wp_enqueue_style('chatify-admin-css', CHATIFY_PLUGIN_URL . 'assets/css/chatify-admin.css', array(), CHATIFY_VERSION);
        wp_enqueue_script('chatify-admin-js', CHATIFY_PLUGIN_URL . 'assets/js/chatify-admin.js', array('jquery'), CHATIFY_VERSION, true);
        
        wp_localize_script('chatify-admin-js', 'chatify_admin_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('chatify_admin_nonce')
        ));
    }
    
    public function test_api_connection() {
        check_ajax_referer('chatify_admin_nonce', 'nonce');
        
        $api = new Chatify_API();
        $result = $api->test_connection();
        
        wp_send_json($result);
    }
    
    public function load_tuning() {
        check_ajax_referer('chatify_admin_nonce', 'nonce');
        
        $api = new Chatify_API();
        $result = $api->get_tuning();
        
        wp_send_json($result);
    }
    
    public function save_tuning() {
        check_ajax_referer('chatify_admin_nonce', 'nonce');
        
        $tuning_text = isset($_POST['tuning_text']) ? wp_unslash($_POST['tuning_text']) : '';
        
        if (empty($tuning_text)) {
            wp_send_json_error('Tuning text is required');
        }
        
        $api = new Chatify_API();
        $result = $api->update_tuning($tuning_text);
        
        wp_send_json($result);
    }
    
    public function delete_tuning() {
        check_ajax_referer('chatify_admin_nonce', 'nonce');
        
        $api = new Chatify_API();
        $result = $api->delete_tuning();
        
        wp_send_json($result);
    }
}
