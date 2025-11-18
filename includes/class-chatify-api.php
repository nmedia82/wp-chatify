<?php
class Chatify_API {
    private $api_endpoint;
    private $domain_token;
    
    public function __construct() {
        $this->api_endpoint = CHATIFY_API_BASE . '/agent/ask';
        $this->domain_token = get_option('chatify_domain_token', '');
    }
    
    public function send_message($question, $session_id = null) {
        if (empty($this->domain_token)) {
            return array('error' => 'Domain token not configured');
        }
        
        $body = array('question' => sanitize_text_field($question));
        if ($session_id) {
            $body['sessionId'] = sanitize_text_field($session_id);
        }
        
        $args = array(
            'method' => 'POST',
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->domain_token
            ),
            'body' => json_encode($body),
            'timeout' => 30
        );
        
        $response = wp_remote_post($this->api_endpoint, $args);
        
        if (is_wp_error($response)) {
            return array('error' => 'Connection failed: ' . $response->get_error_message());
        }
        
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);
        
        // Debug logging
        error_log('Chatify API Response Code: ' . $response_code);
        error_log('Chatify API Response Body: ' . $response_body);
        
        if ($response_code !== 200) {
            $error_msg = 'API Error (' . $response_code . ')';
            if (isset($data['error'])) {
                $error_msg .= ': ' . $data['error'];
            } elseif (isset($data['message'])) {
                $error_msg .= ': ' . $data['message'];
            }
            return array('error' => $error_msg);
        }
        
        if (!$data || !isset($data['answer'])) {
            return array('error' => 'Invalid API response format');
        }
        
        return $data;
    }
    
    public function test_connection() {
        return $this->send_message('Hello, this is a test message.');
    }
    
    public function get_tuning() {
        if (empty($this->domain_token)) {
            return array('error' => 'Domain token not configured');
        }
        
        $response = wp_remote_get(CHATIFY_API_BASE . '/tuning', array(
            'headers' => array('Authorization' => 'Bearer ' . $this->domain_token),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('error' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
    
    public function update_tuning($tuning_text) {
        if (empty($this->domain_token)) {
            return array('error' => 'Domain token not configured');
        }
        
        $response = wp_remote_request(CHATIFY_API_BASE . '/tuning', array(
            'method' => 'PUT',
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->domain_token
            ),
            'body' => json_encode(array('tuningText' => $tuning_text)),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('error' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
    
    public function delete_tuning() {
        if (empty($this->domain_token)) {
            return array('error' => 'Domain token not configured');
        }
        
        $response = wp_remote_request(CHATIFY_API_BASE . '/tuning', array(
            'method' => 'DELETE',
            'headers' => array('Authorization' => 'Bearer ' . $this->domain_token),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return array('error' => $response->get_error_message());
        }
        
        return array('success' => true);
    }
}
