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
 * RakutenRws_HttpClient
 *
 * @package RakutenRws
 */
abstract class RakutenRws_HttpClient
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
