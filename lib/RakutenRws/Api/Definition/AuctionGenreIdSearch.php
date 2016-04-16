<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

namespace RakutenRws\Api\Definition;

use RakutenRws\Api\AppRakutenApi;

/**
 * AuctionGenreIdSearch
 *
 * @package RakutenRws
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
