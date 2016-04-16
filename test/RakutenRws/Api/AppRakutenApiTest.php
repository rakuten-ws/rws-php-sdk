<?php

namespace RakutenRws\Api;

use RakutenRws\Client;
use RakutenRws\Exception;
use RakutenRws\HttpClient;
use RakutenRws\HttpResponse;
use PHPUnit_Framework_TestCase;
use RakutenRws\Api\Definition\DummyAppRakutenApi1;
use RakutenRws\Api\Definition\DummyAppRakutenApi2;
use RakutenRws\Api\Definition\DummyAppRakutenApi3;

class AppRakutenApiTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function testExecuteAppRakutenApi()
    {
        $httpClient = $this->getMock('RakutenRws\HttpClient', array(
            'post',
            'get'
        ), array(), 'httpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/api/DummyService/DummyOperation1/19890108';
        $param = array(
            'access_token' => 'abc'
        );

        $httpResponse = new HttpResponse($url, $param, 200, array(), json_encode(array(
            'Items' => array(array('Item' => 'data'))
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $rwsClient = $this->getMock('RakutenRws\Client', array(
            'getHttpClient',
            'getAccessToken',
        ), array(), 'rwsClient_for_'.__FUNCTION__);

        $rwsClient->expects($this->once())
            ->method('getHttpClient')
            ->will($this->returnValue($httpClient));

        $rwsClient->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue('abc'));

        $api = new DummyAppRakutenApi1($rwsClient);
        $response = $api->execute(array());

        $this->assertEquals('DummyService', $api->getService());
        $this->assertEquals('DummyOperation1', $api->getOperation());
        $this->assertEquals('DummyAppRakutenApi1', $api->getOperationName());
        $this->assertEquals('1989-01-08', $api->getVersion());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals(array(array('Item' => 'data')), $response['Items']);
    }

    /**
     *
     * @test
     */
    public function testExecuteNonAuthorizedAppRakutenApi()
    {
        $httpClient = $this->getMock('RakutenRws\HttpClient', array(
            'post',
            'get'
        ), array(), 'httpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/api/DummyService/DummyOperation2/19890108';
        $param = array(
            'applicationId' => '123',
            'affiliateId'   => '456'
        );

        $httpResponse = new HttpResponse($url, $param, 200, array(), json_encode(array(
            'data' => 'the response'
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $rwsClient = $this->getMock('RakutenRws\Client', array(
            'getHttpClient',
            'getApplicationId',
            'getAffiliateId'
        ), array(), 'rwsClient_for_'.__FUNCTION__);

        $rwsClient->expects($this->once())
            ->method('getHttpClient')
            ->will($this->returnValue($httpClient));

        $rwsClient->expects($this->once())
            ->method('getApplicationId')
            ->will($this->returnValue('123'));

        $rwsClient->expects($this->any())
            ->method('getAffiliateId')
            ->will($this->returnValue('456'));

        $api = new DummyAppRakutenApi2($rwsClient);
        $response = $api->execute(array());

        $this->assertEquals('DummyService', $api->getService());
        $this->assertEquals('DummyOperation2', $api->getOperation());
        $this->assertEquals('DummyAppRakutenApi2', $api->getOperationName());
        $this->assertEquals('1989-01-08', $api->getVersion());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('the response', $response['data']);
    }

    /**
     *
     * @test
     */
    public function testExecutePostAppRakutenApi()
    {
        $httpClient = $this->getMock('RakutenRws\HttpClient', array(
            'post',
            'get'
        ), array(), 'httpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/api/DummyService/DummyOperation3/19890108';
        $param = array(
            'access_token' => 'abc'
        );

        $httpResponse = new HttpResponse($url, $param, 200, array(), json_encode(array(
            'data' => 'the response'
        )));

        $httpClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $rwsClient = $this->getMock('RakutenRws\Client', array(
            'getHttpClient',
            'getAccessToken',
        ), array(), 'rwsClient_for_'.__FUNCTION__);

        $rwsClient->expects($this->once())
            ->method('getHttpClient')
            ->will($this->returnValue($httpClient));

        $rwsClient->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue('abc'));

        $api = new DummyAppRakutenApi3($rwsClient);
        $response = $api->execute(array());

        $this->assertEquals('DummyService', $api->getService());
        $this->assertEquals('DummyOperation3', $api->getOperation());
        $this->assertEquals('DummyAppRakutenApi3', $api->getOperationName());
        $this->assertEquals('1989-01-08', $api->getVersion());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('the response', $response['data']);
    }

    /**
     *
     * @test
     */
    public function testSetVersion()
    {
        $clinet = new Client();
        $api = new DummyAppRakutenApi1($clinet);
        $api->setVersion('2012-01-08');
        $this->assertEquals('2012-01-08', $api->getVersion());
    }

    /**
     *
     * @test
     */
    public function testSetVersionWithoutHyphen()
    {
        $clinet = new Client();
        $api = new DummyAppRakutenApi1($clinet);
        $api->setVersion('20120108');
        $this->assertEquals('2012-01-08', $api->getVersion());
    }

    /**
     *
     * @test
     */
    public function testSetVersionWithNumber()
    {
        $clinet = new Client();
        $api = new DummyAppRakutenApi1($clinet);
        $api->setVersion(20120108);
        $this->assertEquals('2012-01-08', $api->getVersion());
    }

    /**
     *
     * @test
     * @expectedException Exception
     */
    public function testSetVersion_When_Sets_Wrong_Version()
    {
        $clinet = new Client();
        $api = new DummyAppRakutenApi1($clinet);
        $api->setVersion('2020-01-08');
    }

    /**
     *
     * @test
     */
    public function testExecuteNonAuthorizedAppRakutenApi_With_callback()
    {
        $httpClient = $this->getMock('RakutenRws\HttpClient', array(
            'post',
            'get'
        ), array(), 'httpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/api/DummyService/DummyOperation2/19890108';
        $param = array(
            'applicationId' => '123',
            'affiliateId'   => '456'
        );

        $httpResponse = new HttpResponse($url, $param, 200, array(), json_encode(array(
            'data' => 'the response'
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $rwsClient = $this->getMock('RakutenRws\Client', array(
            'getHttpClient',
            'getApplicationId',
            'getAffiliateId'
        ), array(), 'rwsClient_for_'.__FUNCTION__);

        $rwsClient->expects($this->once())
            ->method('getHttpClient')
            ->will($this->returnValue($httpClient));

        $rwsClient->expects($this->once())
            ->method('getApplicationId')
            ->will($this->returnValue('123'));

        $rwsClient->expects($this->any())
            ->method('getAffiliateId')
            ->will($this->returnValue('456'));

        $api = new DummyAppRakutenApi2($rwsClient);
        $response = $api->execute(array('callback' => 'it_will_be_deleted'));

        $this->assertEquals('DummyService', $api->getService());
        $this->assertEquals('DummyOperation2', $api->getOperation());
        $this->assertEquals('DummyAppRakutenApi2', $api->getOperationName());
        $this->assertEquals('1989-01-08', $api->getVersion());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('the response', $response['data']);
    }

    /**
     *
     * @test
     */
    public function testExecuteNonAuthorizedAppRakutenApi_With_format()
    {
        $httpClient = $this->getMock('RakutenRws\HttpClient', array(
            'post',
            'get'
        ), array(), 'httpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/api/DummyService/DummyOperation2/19890108';
        $param = array(
            'applicationId' => '123',
            'affiliateId'   => '456'
        );

        $httpResponse = new HttpResponse($url, $param, 200, array(), json_encode(array(
            'data' => 'the response'
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $rwsClient = $this->getMock('RakutenRws\Client', array(
            'getHttpClient',
            'getApplicationId',
            'getAffiliateId'
        ), array(), 'rwsClient_for_'.__FUNCTION__);

        $rwsClient->expects($this->once())
            ->method('getHttpClient')
            ->will($this->returnValue($httpClient));

        $rwsClient->expects($this->once())
            ->method('getApplicationId')
            ->will($this->returnValue('123'));

        $rwsClient->expects($this->any())
            ->method('getAffiliateId')
            ->will($this->returnValue('456'));

        $api = new DummyAppRakutenApi2($rwsClient);
        $response = $api->execute(array('format' => 'it_will_be_deleted'));

        $this->assertEquals('DummyService', $api->getService());
        $this->assertEquals('DummyOperation2', $api->getOperation());
        $this->assertEquals('DummyAppRakutenApi2', $api->getOperationName());
        $this->assertEquals('1989-01-08', $api->getVersion());
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('the response', $response['data']);
    }

    /**
     *
     * @test
     * @expectedException Exception
     */
    public function testExecuteAppRakutenApi_with_BrokenData()
    {
        $httpClient = $this->getMock('RakutenRws\HttpClient', array(
            'post',
            'get'
        ), array(), 'httpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/api/DummyService/DummyOperation1/19890108';
        $param = array(
            'access_token' => 'abc'
        );

        $httpResponse = new HttpResponse($url, $param, 200, array(), json_encode(array(
            'Ooooooohhhhhhhh!!!!'
        )));

        $httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $rwsClient = $this->getMock('RakutenRws\Client', array(
            'getHttpClient',
            'getAccessToken',
        ), array(), 'rwsClient_for_'.__FUNCTION__);

        $rwsClient->expects($this->once())
            ->method('getHttpClient')
            ->will($this->returnValue($httpClient));

        $rwsClient->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue('abc'));

        $api = new DummyAppRakutenApi1($rwsClient);
        $api->execute(array());
    }
}
