<?php

class RakutenRws_ApiResponse_RwsApiResponseTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'Success',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);

        $response->setIterator(array('foo', 'bar'));

        $this->assertEquals('operation', $response->getOperation());
        $this->assertEquals($httpResponse, $response->getHttpResponse());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('Msg', $response->getMessage());
        $this->assertEquals($data, $response->getData());
        $this->assertTrue(isset($response['Header']));
        $this->assertFalse(isset($response['Foo']));
        $this->assertTrue($response->hasIterator());
        $this->assertEquals(array('foo', 'bar'), iterator_to_array($response));
    }

    public function testSetIterator()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'Success',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);
        $response->setIterator(new ArrayIterator(array('foo', 'bar')));
        $this->assertEquals(array('foo', 'bar'), iterator_to_array($response));
    }

    /**
     *
     * @expectedException BadMethodCallException
     */
    public function testSetIterator_Error()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'Success',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);
        $response->setIterator(null);
    }

    public function testHasIterator_NoIterator()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'Success',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);
        $this->assertFalse($response->hasIterator());
    }



    /**
     *
     * @expectedException LogicException
     */
    public function testOffsetSet()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'Success',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);

        $response['foo'] = 'bar';
    }

    /**
     *
     * @expectedException LogicException
     */
    public function testOffsetUnSet()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'Success',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);

        unset($response['Header']);
    }

    public function testError1()
    {
        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            500,
            array(),
            'Error'
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);

        $this->assertEquals(500, $response->getCode());
    }

    public function testError2()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'NotFound',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);

        $this->assertEquals(404, $response->getCode());
        $this->assertEquals('NotFound: Msg', $response->getMessage());
    }

    public function testError3()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'ServerError',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);

        $this->assertEquals(500, $response->getCode());
        $this->assertEquals('ServerError: Msg', $response->getMessage());
    }

    public function testError4()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'ClientError',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);

        $this->assertEquals(400, $response->getCode());
        $this->assertEquals('ClientError: Msg', $response->getMessage());
    }

    public function testError5()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'AccessForbidden',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);

        $this->assertEquals(403, $response->getCode());
        $this->assertEquals('AccessForbidden: Msg', $response->getMessage());
    }

    public function testError7()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'Maintenance',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);

        $this->assertEquals(503, $response->getCode());
        $this->assertEquals('Maintenance: Msg', $response->getMessage());
    }


    public function testError8()
    {
        $data = array(
            'Header' => array(
                'Status'    => 'AnotherStatus',
                'StatusMsg' => 'Msg'
            ),
            'Body' => 'the body'
        );

        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode($data)
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);

        $this->assertEquals(500, $response->getCode());
        $this->assertEquals('AnotherStatus: Msg', $response->getMessage());
    }

    /**
     *
     * @expectedException RakutenRws_Exception
     */
    public function testBrokenData1()
    {
        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            'broken data ;)'
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);
    }

    /**
     *
     * @expectedException RakutenRws_Exception
     */
    public function testBrokenData2()
    {
        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode(array(
                'foo :('
            ))
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);
    }

    /**
     *
     * @expectedException RakutenRws_Exception
     */
    public function testBrokenData3()
    {
        $httpResponse = new RakutenRws_HttpResponse(
            'http://example.com',
            array(),
            200,
            array(),
            json_encode(array(
                'Body' => 'foo',
                'Header' => array(
                )
            ))
        );
        $response = new RakutenRws_ApiResponse_RwsResponse('operation', $httpResponse);
    }
}
