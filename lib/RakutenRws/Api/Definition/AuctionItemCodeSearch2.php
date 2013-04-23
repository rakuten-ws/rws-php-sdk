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
 * AuctionItemCodeSearch
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_AuctionItemCodeSearch2 extends RakutenRws_Api_AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2013-01-10' => '20130110',
            '2012-10-10' => '20121010'
        );

    public function getService()
    {
        return 'AuctionItemCode';
    }

    public function getOperation()
    {
        return 'Search';
    }
}
