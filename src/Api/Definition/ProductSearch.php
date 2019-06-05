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
 * ProductSearch
 *
 * @package Rakuten\WebService
 * @subpackage Api\Defintion
 */
class ProductSearch extends AppRakutenApi
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
