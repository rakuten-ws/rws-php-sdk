<?php

class RakutenRws_AutoloaderTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function testRegister()
    {
        RakutenRws_Autoloader::register();

        $this->assertTrue(class_exists('RakutenRws_Client'));
        $this->assertFalse(class_exists('Foo'));

        $this->assertEquals(null, RakutenRws_Autoloader::autoload('Foo'));
    }
}
