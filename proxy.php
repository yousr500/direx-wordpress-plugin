<?php
/**
 * @package DirexPlugin
 */

add_action('wp_ajax_direx_auth', 'direx_proxy_handler');
add_action('wp_ajax_nopriv_direx_auth', 'direx_proxy_handler');

function direx_proxy_handler() {
    error_log('proxy.php: direx_proxy_handler called');
    
    if (!check_ajax_referer('direx_auth_nonce', 'nonce', false)) {
        error_log('proxy.php: Invalid nonce');
        wp_send_json_error(['message' => 'Invalid nonce']);
    }

    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        error_log('proxy.php: Missing credentials');
        wp_send_json_error(['message' => 'Missing credentials']);
    }

    $username = sanitize_user($_POST['username']);
    $password = sanitize_text_field($_POST['password']);

    if (empty($username) || empty($password)) {
        error_log('proxy.php: Invalid credentials');
        wp_send_json_error(['message' => 'Invalid credentials']);
    }

    error_log('proxy.php: Username: ' . $username);
    error_log('proxy.php: Password: ' . $password);

    $response = wp_remote_post('https://stagingapi.b2cdelivery.tn/api-token-auth/', [
        'body' => [
            'username' => $username,
            'password' => $password,
        ],
    ]);

    if (is_wp_error($response)) {
        error_log('proxy.php: API request failed: ' . $response->get_error_message());
        wp_send_json_error(['message' => $response->get_error_message()]);
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    error_log('proxy.php: API Response Body: ' . $body);
    error_log('proxy.php: Decoded API Response: ' . print_r($data, true));

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('proxy.php: Failed to decode API response: ' . json_last_error_msg());
        wp_send_json_error(['message' => 'Failed to decode API response']);
    }

    if (isset($data['token'])) {
        wp_send_json_success($data);
    } else {
        $error_message = $data['message'] ?? 'Invalid credentials';
        error_log('proxy.php: Login failed: ' . $error_message);
        wp_send_json_error(['message' => $error_message]);
    }
}