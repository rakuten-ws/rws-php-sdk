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
 * AuctionItemSearch2
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_AuctionItemSearch2 extends RakutenRws_Api_AppRakutenApi
{
    protected
        $autoSetIterator = true,
        $isRequiredAccessToken = false,
        $versionMap = array(
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
