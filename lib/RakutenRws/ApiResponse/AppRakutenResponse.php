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
 * API Response for app.rakuten.co.jp
 *
 * @package RakutenRws
 * @subpackage ApiResponse
 */
class RakutenRws_ApiResponse_AppRakutenResponse extends RakutenRws_ApiResponse
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
            throw new RakutenRws_Exception();
        }

        $this->data = $rawData;
    }
}
