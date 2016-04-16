<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

namespace RakutenRws\Api;

/**
 * The interface of API
 *
 * @package RakutenRws
 * @subpackage Api
 */
interface ApiInterface
{
    public function getAvailableVersions();
    public function getOperationName();
    public function getLatestVersion();
    public function getVersion();
    public function setVersion($version);
    public function execute($parameter);
}
