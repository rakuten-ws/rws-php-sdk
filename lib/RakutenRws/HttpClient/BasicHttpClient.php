<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

/**
 * Http Client that use file_get_contents()
 * This class is needed >= PHP5.2.10
 *
 * @package RakutenRws
 * @subpackage HttpClient
 */
class RakutenRws_HttpClient_BasicHttpClient extends RakutenRws_HttpClient
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
            'header' => 'User-Agent: RakutenWebService SDK for PHP-'.RakutenRws_Client::VERSION,
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

        return new RakutenRws_HttpResponse(
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

        return new RakutenRws_HttpResponse(
            $url,
            $params,
            $headerInfo['code'],
            $headerInfo['headers'],
            $contents);
    }
}
