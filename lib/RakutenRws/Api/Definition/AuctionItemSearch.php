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
 * AuctionItemSearch
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_AuctionItemSearch extends RakutenRws_Api_RwsApi
{
    protected
        $versionMap = array(
            '2013-01-10' => 'RakutenRws_Api_Definition_AuctionItemSearch2',
            '2012-10-10' => 'RakutenRws_Api_Definition_AuctionItemSearch2',
            '2012-02-02' => '3.0',
            '2011-04-20' => '3.0',
            '2010-09-15' => '3.0',
        ),
        $autoSetIterator = true;
}
