<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

namespace Rakuten\WebService;

/**
 * Rakuten\WebService_HttpClient
 *
 * @package Rakuten\WebService
 */
abstract class HttpClient
{
    protected
        $proxy = null,
        $timeout = 10;

    public function setProxy($proxy) {
        $this->proxy = $proxy;
    }

    public function getProxy()
    {
        return $this->proxy;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    abstract public function get($url, $params = array());

    abstract public function post($url, $params = array());
}
