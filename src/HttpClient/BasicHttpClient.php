<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

namespace Rakuten\WebService\HttpClient;

use Rakuten\WebService\Client;
use Rakuten\WebService\HttpClient;
use Rakuten\WebService\HttpResponse;

/**
 * Http Client that use file_get_contents()
 * This class is needed >= PHP5.2.10
 *
 * @package Rakuten\WebService
 * @subpackage HttpClient
 */
class BasicHttpClient extends HttpClient
{
    protected function getStreamContext($url, $params, $method = 'GET')
    {
        $httpConf = array(
            'method' => $method,
            'request_fulluri' => true,
            'ignore_errors'   => true,
            'timeout'         => $this->timeout
        );

        $headers = array(
            'header' => 'User-Agent: RakutenWebService SDK for PHP-'.Client::VERSION,
        );

        if ($method === 'POST') {
            if (count($params) >= 1) {
                $contents = http_build_query($params);
                $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                $headers[] = 'Content-Length: '.strlen($contents);
                $httpConf['content'] = $contents;
            }
        }

        $httpConf['header'] = implode("\r\n", $headers)."\r\n";

        if ($this->proxy !== null) {
            $httpConf['proxy'] = $httpConf['proxy'] = preg_replace(
                array('/^http:/', '/^https:/'),
                array('tcp:', 'ssl:'),
                $this->proxy
            );
        }

        return stream_context_create(array('http' => $httpConf));
    }

    protected function parseHeader($responseHeader)
    {
        $code = null;
        $headers = array();
        if (isset($responseHeader) && is_array($responseHeader)) {
            foreach ($responseHeader as $header) {
                $token = explode(' ', $header);
                if (0 === strpos($token[0], 'HTTP/')) {
                    $headers = array();
                    $code = $token[1];
                }

                $headers[] = $header;
            }
        }

        return array('code' =>  $code, 'headers' => $headers);
    }

    public function get($url, $params = array())
    {
        $context = $this->getStreamContext($url, $params);

        $requestUrl  = $url;
        if (count($params)) {
            $requestUrl .= false === strpos($requestUrl, '?') ? '?' : '&';
            $requestUrl .= http_build_query($params);
        }

        $contents = @file_get_contents($requestUrl, false, $context);
        $headerInfo = $this->parseHeader($http_response_header);

        return new HttpResponse(
            $url,
            $params,
            $headerInfo['code'],
            $headerInfo['headers'],
            $contents
        );
    }

    public function post($url, $params = array())
    {
        $context = $this->getStreamContext($url, $params, 'POST');
        $contents = @file_get_contents($url, false, $context);
        $headerInfo = $this->parseHeader($http_response_header);

        return new HttpResponse(
            $url,
            $params,
            $headerInfo['code'],
            $headerInfo['headers'],
            $contents);
    }
}
