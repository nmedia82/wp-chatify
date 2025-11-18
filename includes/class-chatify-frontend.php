<?php
class Chatify_Frontend {
    
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('wp_footer', array($this, 'render_chat_widget'));
        add_action('wp_ajax_chatify_send_message', array($this, 'handle_ajax_message'));
        add_action('wp_ajax_nopriv_chatify_send_message', array($this, 'handle_ajax_message'));
    }
    
    public function enqueue_frontend_scripts() {
        if (!get_option('chatify_enabled', false)) {
            return;
        }
        
        // Check admin only mode
        if (get_option('chatify_admin_only', false) && !current_user_can('administrator')) {
            return;
        }
        
        wp_enqueue_style('chatify-frontend-css', CHATIFY_PLUGIN_URL . 'assets/css/chatify-frontend.css', array(), CHATIFY_VERSION);
        wp_enqueue_script('chatify-frontend-js', CHATIFY_PLUGIN_URL . 'assets/js/chatify-frontend.js', array('jquery'), CHATIFY_VERSION, true);
        
        wp_localize_script('chatify-frontend-js', 'chatify_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('chatify_nonce'),
            'welcome_message' => get_option('chatify_welcome_message', 'Hello! How can I help you today?')
        ));
    }
    
    public function render_chat_widget() {
        if (!get_option('chatify_enabled', false)) {
            return;
        }
        
        // Check admin only mode
        if (get_option('chatify_admin_only', false) && !current_user_can('administrator')) {
            return;
        }
        
        include CHATIFY_PLUGIN_PATH . 'templates/chat-widget.php';
    }
    
    public function handle_ajax_message() {
        
        if (!wp_verify_nonce($_POST['nonce'], 'chatify_nonce')) {
            error_log('Chatify: Nonce verification failed');
            wp_send_json_error('Security check failed');
        }
        
        $question = isset($_POST['question']) ? wp_unslash($_POST['question']) : '';
        $session_id = isset($_POST['session_id']) ? sanitize_text_field($_POST['session_id']) : null;
        
        if (empty($question)) {
            wp_send_json_error('Question is required');
        }
        
        $api = new Chatify_API();
        $response = $api->send_message($question, $session_id);
        
        error_log('Chatify API Response: ' . print_r($response, true));
        
        if (isset($response['error'])) {
            wp_send_json_error($response['error']);
        }
        
        wp_send_json_success($response);
    }
}
