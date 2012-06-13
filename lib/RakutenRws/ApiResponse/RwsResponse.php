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
 * API Response for api.rakuten.co.jp
 *
 * @package RakutenRws
 * @subpackage ApiResponse
 */
class RakutenRws_ApiResponse_RwsResponse extends RakutenRws_ApiResponse
{
    /**
     * Handles api.rakuten.co.jp's data
     *
     * @throws RakutenRws_Exception
     */
    protected function handleResponse()
    {
        if ($this->httpResponse->getCode() != 200) {
            $this->isOk = false;
            $this->code = $this->httpResponse->getCode();

            return;
        }

        $rawData = json_decode($this->httpResponse->getContents(), true);

        if (null === $rawData)
        {
            throw new RakutenRws_Exception(sprintf('Invalid response: "%s".', $this->httpResponse->getContents()));
        }

        if (!(array_key_exists('Body', $rawData) && array_key_exists('Header', $rawData)))
        {
            throw new RakutenRws_Exception('Invalid Response: There is no Body or Header.');
        }

        $headerInfo = $rawData['Header'];
        if (!(array_key_exists('Status', $headerInfo) && array_key_exists('StatusMsg', $headerInfo))) {
            throw new RakutenRws_Exception('Invalid Response: There is no Status information.');
        }

        $status = $headerInfo['Status'];
        $message = $headerInfo['StatusMsg'];

        $isOk = true;
        if ($status != 'Success')
        {
            $isOk = false;
            $message = $status.': '.$message;
        }

        switch ($status) {
            case 'Success' :
                $code = 200;
                break;
            case 'NotFound' :
                $code = 404;
                break;
            case 'ServerError' :
                $code = 500;
                break;
            case 'ClientError' :
                $code = 400;
                break;
            case 'Maintenance' :
                $code = 503;
                break;
            case 'AccessForbidden' :
                $code = 403;
                break;
            default :
                $code = 500;
        }

        $this->isOk = $isOk;
        $this->code = $code;
        $this->data = $rawData;
        $this->message = $message;
    }
}
