<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

namespace RakutenRws\HttpClient;

use HTTP_Client;
use RakutenRws\Client;
use RakutenRws\Exception;
use RakutenRws\HttpClient;
use RakutenRws\HttpResponse;

/**
 * Http Client that use PEAR Http_Client
 *
 * @package RakutenRws
 * @subpackage HttpClient
 */
class PearHttpClient extends HttpClient
{
    protected
        $client = null;

    public function __construct()
    {
        if (!class_exists('HTTP_Client')) {
            throw new Exception('Failed to include Pear HTTP_Client');
        }

        parent::__construct();
    }

    protected function getHttpClient()
    {
        if ($this->client === null) {
            $this->client = new HTTP_Client();
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

        $this->client->setDefaultHeader('User-Agent', 'RakutenWebService SDK for PHP-'.Client::VERSION);

        return $this->client;
    }

    public function get($url, $params = array())
    {
        $client = $this->getHttpClient();

        $client->get($url, $params);

        $response = $client->currentResponse();

        return new HttpResponse(
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

        return new HttpResponse(
            $url,
            $params,
            $response['code'],
            $response['headers'],
            $response['body']
        );
    }
}
