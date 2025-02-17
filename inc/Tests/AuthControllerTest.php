<?php
/**
 * @package DirexPlugin
 */
namespace Jemaa\DirexPlugin\Tests;

use PHPUnit\Framework\TestCase;
use Jemaa\DirexPlugin\Base\AuthController;

class AuthControllerTest extends TestCase {
    public function testHandleAuthRequest() {
        $authController = new AuthController();

        // Simulate a valid request
        $_POST['username'] = 'testuser';
        $_POST['password'] = 'testpass';
        $_POST['nonce'] = wp_create_nonce('direx_auth_nonce');

        ob_start();
        $authController->handleAuthRequest();
        $output = ob_get_clean();

        $this->assertJson($output);
        $response = json_decode($output, true);
        $this->assertArrayHasKey('success', $response);
    }
}