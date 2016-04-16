<?php

namespace RakutenRws\ApiResponse;

use RakutenRws\Exception;
use RakutenRws\HttpResponse;
use PHPUnit_Framework_TestCase;

class AppRakutenResponseTest extends PHPUnit_Framework_TestCase
{
    public function test() {
        $data = array(
            'data' => 'the data'
        );

        $httpResponse = new HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new AppRakutenResponse('operation', $httpResponse);

        $response->setIterator(array('foo', 'bar'));

        $this->assertEquals('operation', $response->getOperation());
        $this->assertTrue($response->isOk());
        $this->assertEquals($httpResponse, $response->getHttpResponse());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('', $response->getMessage());
        $this->assertEquals($data, $response->getData());
        $this->assertTrue(isset($response['data']));
        $this->assertFalse(isset($response['Foo']));
        $this->assertEquals(array('foo', 'bar'), iterator_to_array($response));

    }

    public function testError() {
        $httpResponse = new HttpResponse(
            'http://example.com',
            array(),
            404,
            array(),
            json_encode(array(
                'error' => 'not_found',
                'error_description' => 'not found'
            ))
        );
        $response = new AppRakutenResponse('operation', $httpResponse);

        $this->assertFalse($response->isOk());
        $this->assertEquals(404, $response->getCode());
        $this->assertEquals('not_found: not found', $response->getMessage());
    }

    /**
     *
     * @expectedException Exception
     */
    public function testBrokenData() {
        $httpResponse = new HttpResponse(
            'http://example.com',
            array(),
            404,
            array(),
            ''
        );
        new AppRakutenResponse('operation', $httpResponse);
    }
}
