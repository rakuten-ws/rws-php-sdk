<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

namespace Rakuten\WebService\Api;

/**
 * The interface of API
 *
 * @package Rakuten\WebService
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
