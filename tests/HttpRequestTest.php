<?php

namespace Rakuten\WebService;

use PHPUnit\Framework\TestCase;
use Rakuten\WebService\HttpClient\BasicHttpClient;

class HttpRequestTest extends TestCase
{
    public function testProxy()
    {
        $client = new BasicHttpClient();
        $client->setProxy('http://example.com');
        $this->assertEquals('http://example.com', $client->getProxy());
    }

    public function testTimeout()
    {
        $client = new BasicHttpClient();
        $client->setTimeout(100);
        $this->assertEquals(100, $client->getTimeout());
    }

}

