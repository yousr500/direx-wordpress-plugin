<?php

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testAddition()
    {
        require_once __DIR__ . '/../direx-plugin.php'; // Include your plugin file

        $result = activate_direx_plugin(); // Call your function
        $this->assertTrue($result);    // Assert the expected behavior
    }
}
