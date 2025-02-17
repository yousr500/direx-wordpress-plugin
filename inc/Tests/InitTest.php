<?php
namespace Jemaa\DirexPlugin\Tests;

use Jemaa\DirexPlugin\Init;
use PHPUnit\Framework\TestCase;

class InitTest extends TestCase {
    public function testInitClassExists() {
        $this->assertTrue(class_exists('Jemaa\\DirexPlugin\\Init'));
    }

    public function testRegisterServices() {
        // Test if the register_services method works
        $this->assertNull(Init::register_services());
    }
}