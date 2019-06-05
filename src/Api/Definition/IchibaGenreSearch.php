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
 * IchibaGenreSearch
 *
 * @package Rakuten\WebService
 * @subpackage Api\Defintion
 */
class IchibaGenreSearch extends AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2014-02-22' => '20140222',
            '2012-07-23' => '20120723'
        );

    public function getService()
    {
        return 'IchibaGenre';
    }

    public function getOperation()
    {
        return 'Search';
    }
}
