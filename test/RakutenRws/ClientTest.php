<?php

class RakutenRws_ClientTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function testGetAuthorizeUrl()
    {
        $clinet = new RakutenRws_Client();

        $clinet->setApplicationId('123');
        $clinet->setSecret('foo-bar');
        $clinet->setRedirectUrl('http://example.com');
        $url = $clinet->getAuthorizeUrl('the_scope');

        $this->assertEquals('https://app.rakuten.co.jp/services/authorize?response_type=code&client_id=123&redirect_uri=http%3A%2F%2Fexample.com&scope=the_scope', $url);
    }

    /**
     *
     * @test
     */
    public function testfetchAccessTokenFromCode1()
    {
        $httpClient = $this->getMock('RakutenRws_HttpClient', array(
            'post',
            'get'
        ), array(), 'HttpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/token';
        $param = array(
            'grant_type'    => 'authorization_code',
            'client_id'     => '123',
            'client_secret' => 'foo-bar',
            'code'          => 'codecode',
            'redirect_uri'  => 'http://example.com'
        );

        $httpResponse = new RakutenRws_HttpResponse($url, $param, 200, array(), json_encode(array(
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

        $clinet = new RakutenRws_Client($httpClient);

        $clinet->setApplicationId('123');
        $clinet->setSecret('foo-bar');
        $clinet->setRedirectUrl('http://example.com');

        $this->assertEquals('abc', $clinet->fetchAccessTokenFromCode('codecode'));
        $this->assertEquals('abc', $clinet->getAccessToken());
    }

    /**
     *
     * @test
     */
    public function testfetchAccessTokenFromCode2()
    {
        $httpClient = $this->getMock('RakutenRws_HttpClient', array(
            'post',
            'get'
        ), array(), 'HttpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/token';
        $param = array(
            'grant_type'    => 'authorization_code',
            'client_id'     => '123',
            'client_secret' => 'foo-bar',
            'code'          => 'codecode',
            'redirect_uri'  => 'http://example.com'
        );

        $httpResponse = new RakutenRws_HttpResponse($url, $param, 401, array(), json_encode(array(
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

        $clinet = new RakutenRws_Client($httpClient);

        $clinet->setApplicationId('123');
        $clinet->setSecret('foo-bar');
        $clinet->setRedirectUrl('http://example.com');

        $this->assertNull($clinet->fetchAccessTokenFromCode('codecode'));
    }

    /**
     *
     * @Test
     */
    public function testfetchAccessTokenFromCode3()
    {
        $httpClient = $this->getMock('RakutenRws_HttpClient', array(
            'post',
            'get'
        ), array(), 'HttpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/token';
        $param = array(
            'grant_type'    => 'authorization_code',
            'client_id'     => '123',
            'client_secret' => 'foo-bar',
            'code'          => 'codecode',
            'redirect_uri'  => 'http://example.com'
        );

        $httpResponse = new RakutenRws_HttpResponse($url, $param, 200, array(), json_encode(array(
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

        $clinet = new RakutenRws_Client($httpClient);

        $clinet->setApplicationId('123');
        $clinet->setSecret('foo-bar');
        $clinet->setRedirectUrl('http://example.com');

        $_GET['code'] = 'codecode';
        $this->assertEquals('abc', $clinet->fetchAccessTokenFromCode());
        $this->assertEquals('abc', $clinet->getAccessToken());
    }

    /**
     *
     * @test
     * @expectedException LogicException
     */
    public function testfetchAccessTokenFromCode4_Error()
    {
        $clinet = new RakutenRws_Client();
        unset($_GET['code']);
        $clinet->fetchAccessTokenFromCode();
    }

    /**
     *
     * @test
     */
    public function testfetchAccessTokenFromCode5_BrokenData()
    {
        $httpClient = $this->getMock('RakutenRws_HttpClient', array(
            'post',
            'get'
        ), array(), 'HttpClient_for_'.__FUNCTION__);

        $url = 'https://app.rakuten.co.jp/services/token';
        $param = array(
            'grant_type'    => 'authorization_code',
            'client_id'     => '123',
            'client_secret' => 'foo-bar',
            'code'          => 'codecode',
            'redirect_uri'  => 'http://example.com'
        );

        $httpResponse = new RakutenRws_HttpResponse($url, $param, 200, array(), json_encode(array(
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

        $clinet = new RakutenRws_Client($httpClient);

        $clinet->setApplicationId('123');
        $clinet->setSecret('foo-bar');
        $clinet->setRedirectUrl('http://example.com');

        $this->assertNull($clinet->fetchAccessTokenFromCode('codecode'));
    }

    /**
     *
     * @test
     */
    public function testSetProxy()
    {
        $clinet = new RakutenRws_Client();
        $clinet->setProxy('http://example.com');
        $this->assertEquals('http://example.com', $clinet->getHttpClient()->getProxy());
    }

    /**
     *
     * @test
     */
    public function testExecute()
    {
        $clinet = new RakutenRws_Client();

        $this->assertInstanceOf('RakutenRws_ApiResponse_RwsResponse', $clinet->execute('MockRwsApi'));
    }

    /**
     *
     * @test
     */
    public function testExecute_with_version()
    {
        $clinet = new RakutenRws_Client();

        $this->assertInstanceOf('RakutenRws_ApiResponse_RwsResponse', $clinet->execute(
            'MockRwsApi',
            array(),
            '1989-01-08'
        ));
    }

    /**
     *
     * @test
     * @expectedException LogicException
     */
    public function testExecute_with_WrongOperation()
    {
        $clinet = new RakutenRws_Client();

        $this->assertInstanceOf('RakutenRws_ApiResponse_RwsResponse', $clinet->execute(
            'WrongOperation'
        ));
    }


}
