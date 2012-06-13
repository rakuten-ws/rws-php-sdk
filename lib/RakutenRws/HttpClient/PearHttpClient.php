<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */


require_once 'HTTP/Client.php';

/**
 * Http Client that use PEAR Http_Client
 *
 * @package RakutenRws
 * @subpackage HttpClient
 */
class RakutenRws_HttpClient_PearHttpClient extends RakutenRws_HttpClient
{
    protected
        $client = null;

    protected function getHttpClient()
    {
        if ($this->client === null) {
            $this->client = new Http_Client();
        }

        if ($this->proxy !== null) {
            $parsedUrl = parse_url($this->proxy);
            $this->client->setRequestParameter('proxy_host', $parsedUrl['host']);

            if (isset($parsedUrl['port'])) {
                $this->client->setRequestParameter('proxy_port', $parsedUrl['port']);
            }

            if (isset($parsedUrl['user'])) {
                $this->client->setRequestParameter('proxy_user', $parsedUrl['user']);
            }

            if (isset($parsedUrl['pass'])) {
                $this->client->setRequestParameter('proxy_pass', $parsedUrl['pass']);
            }
        }

        $this->client->setRequestParameter('timeout', $this->timeout);

        $this->client->setDefaultHeader('User-Agent', 'RakutenWebService SDK for PHP-'.RakutenRws_Client::VERSION);

        return $this->client;
    }

    public function get($url, $params = array())
    {
        $client = $this->getHttpClient();

        $client->get($url, $params);

        $response = $client->currentResponse();

        return new RakutenRws_HttpResponse(
            $url,
            $params,
            $response['code'],
            $response['headers'],
            $response['body']
        );
    }

    public function post($url, $params = array())
    {
        $client = $this->getHttpClient();

        $client->post($url, $params);

        $response = $client->currentResponse();

        return new RakutenRws_HttpResponse(
            $url,
            $params,
            $response['code'],
            $response['headers'],
            $response['body']
        );
    }
}
