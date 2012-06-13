<?php

class RakutenRws_HttpRequestTest extends PHPUnit_Framework_TestCase
{
    public function testProxy()
    {
        $client = new RakutenRws_HttpClient_BasicHttpClient();
        $client->setProxy('http://example.com');
        $this->assertEquals('http://example.com', $client->getProxy());
    }

    public function testTimeout()
    {
        $client = new RakutenRws_HttpClient_BasicHttpClient();
        $client->setTimeout(100);
        $this->assertEquals(100, $client->getTimeout());
    }

}

