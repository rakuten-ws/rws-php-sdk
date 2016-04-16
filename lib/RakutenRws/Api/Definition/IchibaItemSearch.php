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
 * IchibaItemSearch
 *
 * @package RakutenRws
 * @subpackage Api\Definition
 */
class IchibaItemSearch extends AppRakutenApi
{
    protected
        $autoSetIterator = true,
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2014-02-22' => '20140222',
            '2013-08-05' => '20130805',
            '2013-04-24' => '20130424',
            '2012-07-23' => '20120723'
        );

    public function getService()
    {
        return 'IchibaItem';
    }

    public function getOperation()
    {
        return 'Search';
    }
}

