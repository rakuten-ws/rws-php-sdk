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
 * RakutenRws_HttpResponse
 *
 * @package RakutenRws
 */
class RakutenRws_HttpResponse
{
    protected
        $requestUrl = null,
        $parameter  = null,
        $code       = 200,
        $contents   = null,
        $headers    = null;

    public function __construct($requestUrl, $parameter, $code, $headers, $contents)
    {
        $this->requestUrl = $requestUrl;
        $this->parameter  = $parameter;
        $this->code       = $code;
        $this->headers    = $headers;
        $this->contents   = $contents;
    }

    public function getUrl() {
        return $this->requestUrl;
    }

    public function getParameter() {
        return $this->parameter;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getContents()
    {
        return $this->contents;
    }
}
