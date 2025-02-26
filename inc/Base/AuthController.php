<?php
/**
 * @package DirexPlugin
 */
namespace Jemaa\DirexPlugin\Base;

use Jemaa\DirexPlugin\Base\BaseController;

class AuthController extends BaseController
{
    public function register(): void {
        // Register AJAX actions
        add_action('wp_ajax_direx_auth', [$this, 'handleAuthRequest']);
        add_action('wp_ajax_nopriv_direx_auth', [$this, 'handleAuthRequest']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue']);
    }

    public function handleAuthRequest() {
        check_ajax_referer('direx_nonce_action', 'nonce');
    
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            error_log('Missing credentials');
            wp_send_json_error(['message' => 'Missing credentials']);
        }
    
        $username = sanitize_user($_POST['username']);
        $password = sanitize_text_field($_POST['password']);
    
        if (empty($username)) {
            error_log('Username cannot be empty');
            wp_send_json_error(['message' => 'Username cannot be empty']);
        }
    
        if (empty($password)) {
            error_log('Password cannot be empty');
            wp_send_json_error(['message' => 'Password cannot be empty']);
        }
    
        $response = wp_remote_post('https://stagingapi.b2cdelivery.tn/api-token-auth/', [
            'body' => [
                'username' => $username,
                'password' => $password,
            ],
        ]);
    
        if (is_wp_error($response)) {
            error_log('API request failed: ' . $response->get_error_message());
            wp_send_json_error(['message' => 'API request failed: ' . $response->get_error_message()]);
        }
    
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
    
        // Log the entire response for debugging
        error_log('API Response Body: ' . $body);
        error_log('Decoded API Response: ' . print_r($data, true));
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('Failed to decode API response: ' . json_last_error_msg());
            wp_send_json_error(['message' => 'Failed to decode API response: ' . json_last_error_msg()]);
        }
    
        // Check if the response contains the expected fields
        if (isset($data['token'])) {
            // Log the token and other data being sent in the response
            error_log('Token: ' . $data['token']);
            error_log('User ID: ' . $data['user_id']);
            error_log('Email: ' . $data['email']);
            error_log('Role: ' . $data['role']);
    
            // Send the response
            wp_send_json_success([
                'token' => $data['token'],
                'user_id' => $data['user_id'],
                'email' => $data['email'],
                'role' => $data['role'],
            ]);
        } else {
            $error_message = $data['message'] ?? 'Invalid credentials';
            error_log('Login failed: ' . $error_message);
            wp_send_json_error(['message' => $error_message]);
        }
    }
    public function enqueue(): void {
        // Only enqueue on plugin pages
        $screen = get_current_screen();
        if (strpos($screen->id, 'direx_auth') === false) {
            return;
        }

        wp_enqueue_style(
            'direx-auth-style',
            $this->plugin_url . 'assets/css/auth.css',
            [],
            filemtime($this->plugin_path . 'assets/css/auth.css')
        );

        wp_enqueue_script(
            'direx-auth-script',
            $this->plugin_url . 'assets/js/auth.js',
            ['jquery'],  // Dependencies
            '1.0.0',
            true,
            filemtime($this->plugin_path . 'assets/js/auth.js'),
            true
        );
        $nonce = wp_create_nonce('direx_nonce_action');
        wp_localize_script('direx-auth-script', 'direxAjax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => $nonce
        ]);
        
    
        
        
    }
}