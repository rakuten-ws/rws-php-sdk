<?php

namespace Rakuten\WebService;

use LogicException;
use PHPUnit\Framework\TestCase;
use Rakuten\WebService\ApiResponse;

class ClientTest extends TestCase
{
    public function testGetAuthorizeUrl()
    {
        $client = new Client();

        $client->setApplicationId('123');
        $client->setSecret('foo-bar');
        $client->setRedirectUrl('http://example.com');
        $url = $client->getAuthorizeUrl('the_scope');

        $this->assertEquals('https://app.rakuten.co.jp/services/authorize?response_type=code&client_id=123&redirect_uri=http%3A%2F%2Fexample.com&scope=the_scope', $url);
    }

    public function testfetchAccessTokenFromCode1()
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(array(
                'post',
                'get'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('HttpClient_for_'.__FUNCTION__)
            ->getMock();

        $url = 'https://app.rakuten.co.jp/services/token';
        $param = array(
            'grant_type'    => 'authorization_code',
            'client_id'     => '123',
            'client_secret' => 'foo-bar',
            'code'          => 'codecode',
            'redirect_uri'  => 'http://example.com'
        );

        $httpResponse = new HttpResponse($url, $param, 200, array(), json_encode(array(
            'access_token'  => 'abc',
            'refresh_token' => 'def',
            'token_type'    => 'BEARER',
            'expires_in'    => 300,
            'scope'         => 'the_scope'
        )));

        $httpClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $client = new Client($httpClient);

        $client->setApplicationId('123');
        $client->setSecret('foo-bar');
        $client->setRedirectUrl('http://example.com');

        $this->assertEquals('abc', $client->fetchAccessTokenFromCode('codecode'));
        $this->assertEquals('abc', $client->getAccessToken());
    }

    public function testfetchAccessTokenFromCode2()
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(array(
                'post',
                'get'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('HttpClient_for_'.__FUNCTION__)
            ->getMock();

        $url = 'https://app.rakuten.co.jp/services/token';
        $param = array(
            'grant_type'    => 'authorization_code',
            'client_id'     => '123',
            'client_secret' => 'foo-bar',
            'code'          => 'codecode',
            'redirect_uri'  => 'http://example.com'
        );

        $httpResponse = new HttpResponse($url, $param, 401, array(), json_encode(array(
            'error'             => 'invalid_request',
            'error_description' => 'invalid code'
        )));

        $httpClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $client = new Client($httpClient);

        $client->setApplicationId('123');
        $client->setSecret('foo-bar');
        $client->setRedirectUrl('http://example.com');

        $this->assertNull($client->fetchAccessTokenFromCode('codecode'));
    }

    public function testfetchAccessTokenFromCode3()
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(array(
                'post',
                'get'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('HttpClient_for_'.__FUNCTION__)
            ->getMock();

        $url = 'https://app.rakuten.co.jp/services/token';
        $param = array(
            'grant_type'    => 'authorization_code',
            'client_id'     => '123',
            'client_secret' => 'foo-bar',
            'code'          => 'codecode',
            'redirect_uri'  => 'http://example.com'
        );

        $httpResponse = new HttpResponse($url, $param, 200, array(), json_encode(array(
            'access_token'  => 'abc',
            'refresh_token' => 'def',
            'token_type'    => 'BEARER',
            'expires_in'    => 300,
            'scope'         => 'the_scope'
        )));

        $httpClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $client = new Client($httpClient);

        $client->setApplicationId('123');
        $client->setSecret('foo-bar');
        $client->setRedirectUrl('http://example.com');

        $_GET['code'] = 'codecode';
        $this->assertEquals('abc', $client->fetchAccessTokenFromCode());
        $this->assertEquals('abc', $client->getAccessToken());
    }

    public function testfetchAccessTokenFromCode4_Error()
    {
        $this->expectException(LogicException::class);
        $client = new Client();
        unset($_GET['code']);
        $client->fetchAccessTokenFromCode();
    }

    public function testfetchAccessTokenFromCode5_BrokenData()
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(array(
                'post',
                'get'
            ))
            ->setConstructorArgs(array())
            ->setMockClassName('HttpClient_for_'.__FUNCTION__)
            ->getMock();

        $url = 'https://app.rakuten.co.jp/services/token';
        $param = array(
            'grant_type'    => 'authorization_code',
            'client_id'     => '123',
            'client_secret' => 'foo-bar',
            'code'          => 'codecode',
            'redirect_uri'  => 'http://example.com'
        );

        $httpResponse = new HttpResponse($url, $param, 200, array(), json_encode(array(
            'error'             => 'invalid_request',
            'error_description' => 'invalid code'
        )));

        $httpClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo($url),
                $this->equalTo($param)
            )
            ->will($this->returnValue($httpResponse));

        $client = new Client($httpClient);

        $client->setApplicationId('123');
        $client->setSecret('foo-bar');
        $client->setRedirectUrl('http://example.com');

        $this->assertNull($client->fetchAccessTokenFromCode('codecode'));
    }

    public function testSetProxy()
    {
        $client = new Client();
        $client->setProxy('http://example.com');
        $this->assertEquals('http://example.com', $client->getHttpClient()->getProxy());
    }

    public function testExecute()
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

        $client = new Client($httpClient);
        $client->setApplicationId('123');
        $client->setAffiliateId('456');
        $response = $client->execute('DummyAppRakutenApi2');
        $this->assertInstanceOf(ApiResponse::class, $response);
    }

    public function testExecuteWithOperationAlias()
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

        $client = new Client($httpClient);
        $client->setApplicationId('123');
        $client->setAffiliateId('456');
        $response = $client->execute('DummyAppRakuten/Api2');
        $this->assertInstanceOf(ApiResponse::class, $response);
    }

    public function testExecute_with_WrongOperation()
    {
        $this->expectException(LogicException::class);
        $client = new Client();

        $client->execute('WrongOperation');
    }
}
