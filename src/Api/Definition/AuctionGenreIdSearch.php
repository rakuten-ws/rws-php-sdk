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

/**
 * AuctionGenreIdSearch
 *
 * @package Rakuten\WebService
 * @subpackage Api\Definition
 */
class AuctionGenreIdSearch extends AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2012-09-27' => '20120927'
        );

    public function getService()
    {
        return 'AuctionGenreId';
    }

    public function getOperation()
    {
        return 'Search';
    }
}
