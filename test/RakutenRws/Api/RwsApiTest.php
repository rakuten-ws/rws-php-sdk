<?php

class RakutenRws_RwsApiTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function testExecuteRwsApi()
    {
        $httpClient = $this->getMock('RakutenRws_HttpClient', array(
            'post',
            'get'
        ), array(), 'HttpClient_for_'.__FUNCTION__);

        $url = 'http://api.rakuten.co.jp/rws/3.0/json?version=1989-01-08&operation=DummyRwsApi1&developerId=123&affiliateId=456';

        $httpResponse = new RakutenRws_HttpResponse($url, array(), 200, array(), json_encode(array(
            'Header' => array(
                'Status' => 'Success',
                'StatusMsg' => 'The msg'
             ),
             'Body' => array(
                 'data' => ':)'
             )
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo(array())
            )
            ->will($this->returnValue($httpResponse));

        $clinet = new RakutenRws_Client($httpClient);
        $clinet->setApplicationId('123');
        $clinet->setAffiliateId('456');
        $api = new RakutenRws_Api_Definition_DummyRwsApi1($clinet);
        $response = $api->execute(array());

        $this->assertEquals('1989-01-08', $api->getVersion());
        $this->assertEquals('DummyRwsApi1', $api->getOperationName());
        $this->assertTrue($response->isOk());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('The msg', $response->getMessage());
        $this->assertEquals(':)', $response['Body']['data']);
    }

    /**
     *
     * @test
     */
    public function testExecuteIteratableRwsApi()
    {
        $httpClient = $this->getMock('RakutenRws_HttpClient', array(
            'post',
            'get'
        ), array(), 'HttpClient_for_'.__FUNCTION__);

        $url = 'http://api.rakuten.co.jp/rws/3.0/json?version=1989-01-08&operation=DummyRwsApi2&developerId=123';

        $httpResponse = new RakutenRws_HttpResponse($url, array(), 200, array(), json_encode(array(
            'Header' => array(
                'Status' => 'Success',
                'StatusMsg' => 'The msg'
             ),
             'Body' => array(
                'DummyRwsApi2' => array(
                    'Items' => array(
                        'Item' => array(
                            'the',
                            'data'
                        )
                    )
                )
             )
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo(array())
            )
            ->will($this->returnValue($httpResponse));

        $clinet = new RakutenRws_Client($httpClient);
        $clinet->setApplicationId('123');

        $api = new RakutenRws_Api_Definition_DummyRwsApi2($clinet);

        $response = $api->execute(array());

        $this->assertEquals('1989-01-08', $api->getVersion());
        $this->assertEquals('DummyRwsApi2', $api->getOperationName());
        $this->assertTrue($response->isOk());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('The msg', $response->getMessage());

        $this->assertEquals(array(
            'the',
            'data'
        ), iterator_to_array($response));
    }

    /**
     *
     * @test
     * @expectedException RakutenRws_Exception
     */
    public function testExecuteIteratableRwsApi_When_DataIsBroken()
    {
        $httpClient = $this->getMock('RakutenRws_HttpClient', array(
            'post',
            'get'
        ), array(), 'HttpClient_for_'.__FUNCTION__);

        $url = 'http://api.rakuten.co.jp/rws/3.0/json?version=1989-01-08&operation=DummyRwsApi2&developerId=123';

        $httpResponse = new RakutenRws_HttpResponse($url, array(), 200, array(), json_encode(array(
            'Header' => array(
                'Status' => 'Success',
                'StatusMsg' => 'The msg'
             ),
             'Body' => array(
                 'DummyRwsApi2' => array(
                     'broken data'
                )
             )
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo(array())
            )
            ->will($this->returnValue($httpResponse));

        $clinet = new RakutenRws_Client($httpClient);
        $clinet->setApplicationId('123');

        $api = new RakutenRws_Api_Definition_DummyRwsApi2($clinet);

        $response = $api->execute(array());
    }

    /**
     *
     * @test
     */
    public function testSetVersion()
    {
        $clinet = new RakutenRws_Client();
        $api = new RakutenRws_Api_Definition_DummyRwsApi1($clinet);
        $api->setVersion('2012-01-08');
        $this->assertEquals('2012-01-08', $api->getVersion());

        $api->setVersion('1989-01-08');
        $this->assertEquals('1989-01-08', $api->getVersion());
    }

    /**
     *
     * @test
     * @expectedException RakutenRws_Exception
     */
    public function testSetVersion_When_Sets_Wrong_Version()
    {
        $clinet = new RakutenRws_Client();
        $api = new RakutenRws_Api_Definition_DummyRwsApi1($clinet);
        $api->setVersion('2020-01-08');
    }

    /**
     *
     * @test
     */
    public function testExecuteRwsApi_With_callBack()
    {
        $httpClient = $this->getMock('RakutenRws_HttpClient', array(
            'post',
            'get'
        ), array(), 'HttpClient_for_'.__FUNCTION__);

        $url = 'http://api.rakuten.co.jp/rws/3.0/json?version=1989-01-08&operation=DummyRwsApi1&developerId=123&affiliateId=456';

        $httpResponse = new RakutenRws_HttpResponse($url, array(), 200, array(), json_encode(array(
            'Header' => array(
                'Status' => 'Success',
                'StatusMsg' => 'The msg'
             ),
             'Body' => array(
                 'data' => ':)'
             )
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo(array())
            )
            ->will($this->returnValue($httpResponse));

        $clinet = new RakutenRws_Client($httpClient);
        $clinet->setApplicationId('123');
        $clinet->setAffiliateId('456');
        $api = new RakutenRws_Api_Definition_DummyRwsApi1($clinet);
        $response = $api->execute(array('callBack' => 'foo'));

        $this->assertEquals('1989-01-08', $api->getVersion());
        $this->assertEquals('DummyRwsApi1', $api->getOperationName());
        $this->assertTrue($response->isOk());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('The msg', $response->getMessage());
        $this->assertEquals(':)', $response['Body']['data']);
    }

    /**
     *
     * @test
     */
    public function testExecuteRwsApi_with_Alias()
    {
        $httpClient = $this->getMock('RakutenRws_HttpClient', array(
            'post',
            'get'
        ), array(), 'HttpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/api/DummyService/DummyOperation2/19890108';
        $param = array(
            'applicationId' => '123',
            'affiliateId'   => '456'
        );

        $httpResponse = new RakutenRws_HttpResponse($url, $param, 200, array(), json_encode(array(
            'data' => 'the response'
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $clinet = new RakutenRws_Client($httpClient);
        $clinet->setApplicationId('123');
        $clinet->setAffiliateId('456');
        $api = new RakutenRws_Api_Definition_DummyRwsApi3($clinet);
        $response = $api->execute(array());

        $this->assertEquals('1989-01-08', $api->getVersion());
        $this->assertEquals('DummyRwsApi3', $api->getOperationName());
        $this->assertTrue($response->isOk());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('the response', $response['data']);
    }

    /**
     *
     * @test
     */
    public function testExecuteRwsApi_with_Alias_Skip()
    {
        $httpClient = $this->getMock('RakutenRws_HttpClient', array(
            'post',
            'get'
        ), array(), 'HttpClient_for_'.__FUNCTION__);

        $url = 'http://api.rakuten.co.jp/rws/3.0/json?version=1989-01-07&operation=DummyRwsApi3&developerId=123&affiliateId=456';

        $httpResponse = new RakutenRws_HttpResponse($url, array(), 200, array(), json_encode(array(
            'Header' => array(
                'Status' => 'Success',
                'StatusMsg' => 'The msg'
             ),
             'Body' => array(
                 'data' => ':)'
             )
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo(array())
            )
            ->will($this->returnValue($httpResponse));

        $clinet = new RakutenRws_Client($httpClient);
        $clinet->setApplicationId('123');
        $clinet->setAffiliateId('456');
        $api = new RakutenRws_Api_Definition_DummyRwsApi3($clinet, array('is_use_alias' => false));
        $response = $api->execute(array());

        $this->assertEquals('1989-01-07', $api->getVersion());
        $this->assertEquals('DummyRwsApi3', $api->getOperationName());
        $this->assertTrue($response->isOk());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('The msg', $response->getMessage());
        $this->assertEquals(':)', $response['Body']['data']);
    }
}
