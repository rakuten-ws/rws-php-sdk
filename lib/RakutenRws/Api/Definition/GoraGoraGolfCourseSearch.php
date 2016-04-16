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
 * GoraGoraGolfCourseSearch
 *
 * @package RakutenRws
 * @subpackage Api\Definition
 */
class GoraGoraGolfCourseSearch extends AppRakutenApi
{
    protected
        $autoSetIterator = true,
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2013-11-13' => '20131113',
        );

    public function getService()
    {
        return 'Gora';
    }

    public function getOperation()
    {
        return 'GoraGolfCourseSearch';
    }
}
