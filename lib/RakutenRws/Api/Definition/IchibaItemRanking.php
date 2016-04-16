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
 * IchibaItemRanking
 *
 * @package RakutenRws
 * @subpackage Api\Definition
 */
class IchibaItemRanking extends AppRakutenApi
{
    protected
        $autoSetIterator = true,
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2012-09-27' => '20120927'
        );

    public function getService()
    {
        return 'IchibaItem';
    }

    public function getOperation()
    {
        return 'Ranking';
    }
}
