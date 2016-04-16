<?php

namespace RakutenRws;

use PHPUnit_Framework_TestCase;

class HttpResponseTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $response = new HttpResponse(
            'http://example.com',
            array('key' => 'value'),
            200,
            array('Header: foo'),
            'content'
        );

        $this->assertEquals('http://example.com', $response->getUrl());
        $this->assertEquals(array('key' => 'value'), $response->getParameter());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals(array('Header: foo'), $response->getHeaders());
        $this->assertEquals('content', $response->getContents());
    }
}

