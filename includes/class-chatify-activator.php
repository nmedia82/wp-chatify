<?php
class Chatify_Activator {
    
    public static function activate() {
        add_option('chatify_enabled', 0);
        add_option('chatify_domain_token', '');
        add_option('chatify_widget_position', 'bottom-right');
        add_option('chatify_widget_color', '#007cba');
        add_option('chatify_welcome_message', 'Hello! How can I help you today?');
    }
    
    public static function deactivate() {
        // Keep settings on deactivation
    }
}
