<?php
/**
 * @package DirexPlugin
 */

namespace Jemaa\DirexPlugin\Base;

use WP_REST_Controller;

class ApiController extends WP_REST_Controller
{
    public function register(): void
    {
        add_action('rest_api_init', [$this, 'register_routes']);
        error_log('ApiController registered');

    }

    public function register_routes(): void
    {

        register_rest_route('direx/v1', '/login', [
            'methods' => 'POST',
            'callback' => [$this, 'handle_login'],
            'permission_callback' => '__return_true',
        ]);
        

        
    }

    public function handle_login(\WP_REST_Request $request) {
        error_log('Login endpoint hit');

        try {
            $username = sanitize_user($request->get_param('username'));
            $password = sanitize_text_field($request->get_param('password'));
    
            if (empty($username) || empty($password)) {
                throw new \Exception('Username and password are required');
            }
    
            $response = wp_remote_post('https://stagingapi.b2cdelivery.tn/api-token-auth/', [
                'body' => [
                    'username' => $username,
                    'password' => $password,
                ],
            ]);
    
            if (is_wp_error($response)) {
                throw new \Exception($response->get_error_message());
            }
    
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Failed to decode API response');
            }
    
            if (isset($data['token'])) {
                return rest_ensure_response([
                    'token' => $data['token'],
                    'user_id' => $data['user_id'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                ]);
            } else {
                throw new \Exception($data['message'] ?? 'Invalid credentials');
            }
        } catch (\Exception $e) {
            error_log('Login Error: ' . $e->getMessage());
            return new \WP_Error('login_error', $e->getMessage(), ['status' => 500]);
        }
    }


    

    public function check_permissions(\WP_REST_Request $request)
    {
        return current_user_can('manage_options') && wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest');
    }
}