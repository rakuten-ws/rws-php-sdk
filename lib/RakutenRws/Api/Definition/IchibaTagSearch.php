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
 * IchibaTagSearch
 *
 * @package RakutenRws
 * @subpackage Api\Definition
 */
class IchibaTagSearch extends AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2014-02-22' => '20140222'
        );

    public function getService()
    {
        return 'IchibaTag';
    }

    public function getOperation()
    {
        return 'Search';
    }
}
