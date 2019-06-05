<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

namespace Rakuten\WebService\Api\Definition;

use Rakuten\WebService\Api\AppRakutenApi;
use Rakuten\WebService\Exception;

/**
 * AuctionGenreKeywordSearch
 *
 * @package Rakuten\WebService
 * @subpackage Api\Defintion
 */
class AuctionGenreKeywordSearch extends AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2012-09-27' => '20120927'
        );

    public function getService()
    {
        return 'AuctionGenreKeyword';
    }

    public function getOperation()
    {
        return 'Search';
    }

    public function execute($parameter)
    {
        $appresponse = parent::execute($parameter);

        if ($appresponse->isOk()) {
            $data = $appresponse->getData();
            if (!isset($data['auctionGenreList'])) {
                throw new Rakuten\WebService_Exception();
            }

            $appresponse->setIterator($data['auctionGenreList']);
        }

        return $appresponse;
    }
}
