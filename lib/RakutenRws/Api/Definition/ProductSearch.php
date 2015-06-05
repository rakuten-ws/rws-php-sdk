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
 * ProductSearch
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_ProductSearch extends RakutenRws_Api_AppRakutenApi
{
    protected
        $autoSetIterator = true,
        $arrayName = 'Products',
        $entityName = 'Product',
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2014-03-05' => '20140305',
        );

    public function getService()
    {
        return 'Product';
    }

    public function getOperation()
    {
        return 'Search';
    }
}
