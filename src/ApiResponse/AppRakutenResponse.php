<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

namespace Rakuten\WebService\ApiResponse;

use Rakuten\WebService\ApiResponse;
use Rakuten\WebService\Exception;

/**
 * API Response for app.rakuten.co.jp
 *
 * @package Rakuten\WebService
 * @subpackage ApiResponse
 */
class AppRakutenResponse extends ApiResponse
{
    protected function handleResponse()
    {
        if ($this->httpResponse->getCode() != 200) {
            $this->isOk = false;

            $errorData = json_decode($this->httpResponse->getContents(), true);
            if (isset($errorData['error']) && isset($errorData['error_description'])) {
                $this->message = $errorData['error'].': '.$errorData['error_description'];
            }
        }

        $rawData = json_decode($this->httpResponse->getContents(), true);

        if (null === $rawData)
        {
            throw new Exception();
        }

        $this->data = $rawData;
    }
}
