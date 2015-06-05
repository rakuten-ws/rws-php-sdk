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
 * HighCommissionShopList
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_HighCommissionShopList extends RakutenRws_Api_AppRakutenApi
{
    protected
        $autoSetIterator = true,
        $arrayName = 'Shops',
        $entityName = 'Shop',
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2013-12-05' => '20131205',
        );

    public function getService()
    {
        return 'HighCommissionShop';
    }

    public function getOperation()
    {
        return 'List';
    }
}
