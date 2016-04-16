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
 * AuctionItemSearch2
 *
 * @package RakutenRws
 * @subpackage Api\Definition
 */
class AuctionItemSearch extends AppRakutenApi
{
    protected
        $autoSetIterator = true,
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2013-09-05' => '20130905',
            '2013-01-10' => '20130110',
            '2013-10-10' => '20131010'
        );

    public function getService()
    {
        return 'AuctionItem';
    }

    public function getOperation()
    {
        return 'Search';
    }
}
