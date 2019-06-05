<?php

namespace Rakuten\WebService\Api;

use PHPUnit\Framework\TestCase;
use Rakuten\WebService\Api\Definition\DummyAppRakutenApi1;
use Rakuten\WebService\Api\Definition\DummyAppRakutenApi2;
use Rakuten\WebService\Api\Definition\DummyAppRakutenApi3;
use Rakuten\WebService\Client;
use Rakuten\WebService\Exception;
use Rakuten\WebService\HttpClient;
use Rakuten\WebService\HttpResponse;

class AppRakutenApiTest extends TestCase
{
    public function testExecuteAppRakutenApi()
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(array(
                'post',
                'get'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('httpClient_for_'.__FUNCTION__)
            ->getMock();

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

        $rwsClient = $this->getMockBuilder(Client::class)
            ->setMethods(array(
            'getHttpClient',
            'getAccessToken',
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('rwsClient_for_'.__FUNCTION__)
            ->getMock();

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

    public function testExecuteNonAuthorizedAppRakutenApi()
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(array(
                'post',
                'get'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('httpClient_for_'.__FUNCTION__)
            ->getMock();

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

        $rwsClient = $this->getMockBuilder(Client::class) 
            ->setMethods(array(
                'getHttpClient',
                'getApplicationId',
                'getAffiliateId'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('rwsClient_for_'.__FUNCTION__)
            ->getMock();

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

    public function testExecutePostAppRakutenApi()
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(array(
                'post',
                'get'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('httpClient_for_'.__FUNCTION__)
            ->getMock();

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

        $rwsClient = $this->getMockBuilder(Client::class)
            ->setMethods(array(
                'getHttpClient',
                'getAccessToken',
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('rwsClient_for_'.__FUNCTION__)
            ->getMock();

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

    public function testSetVersion()
    {
        $client = new Client();
        $api = new DummyAppRakutenApi1($client);
        $api->setVersion('2012-01-08');
        $this->assertEquals('2012-01-08', $api->getVersion());
    }

    public function testSetVersionWithoutHyphen()
    {
        $client = new Client();
        $api = new DummyAppRakutenApi1($client);
        $api->setVersion('20120108');
        $this->assertEquals('2012-01-08', $api->getVersion());
    }

    public function testSetVersionWithNumber()
    {
        $client = new Client();
        $api = new DummyAppRakutenApi1($client);
        $api->setVersion(20120108);
        $this->assertEquals('2012-01-08', $api->getVersion());
    }

    public function testSetVersion_When_Sets_Wrong_Version()
    {
        $this->expectException(Exception::class);
        $client = new Client();
        $api = new DummyAppRakutenApi1($client);
        $api->setVersion('2020-01-08');
    }

    public function testExecuteNonAuthorizedAppRakutenApi_With_callback()
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(array(
                'post',
                'get'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('httpClient_for_'.__FUNCTION__)
            ->getMock();

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

        $rwsClient = $this->getMockBuilder(Client::class)
            ->setMethods(array(
                'getHttpClient',
                'getApplicationId',
                'getAffiliateId'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('rwsClient_for_'.__FUNCTION__)
            ->getMock();

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

    public function testExecuteNonAuthorizedAppRakutenApi_With_format()
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(array(
                'post',
                'get'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('httpClient_for_'.__FUNCTION__)
            ->getMock();

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

        $rwsClient = $this->getMockBuilder(Client::class)
            ->setMethods(array(
                'getHttpClient',
                'getApplicationId',
                'getAffiliateId'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('rwsClient_for_'.__FUNCTION__)
            ->getMock();

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

    public function testExecuteAppRakutenApi_with_BrokenData()
    {
        $this->expectException(Exception::class);
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(array(
                'post',
                'get'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('httpClient_for_'.__FUNCTION__)
            ->getMock();

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

        $rwsClient = $this->getMockBuilder(Client::class)
            ->setMethods(array(
                'getHttpClient',
                'getAccessToken',
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('rwsClient_for_'.__FUNCTION__)
            ->getMock();

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
