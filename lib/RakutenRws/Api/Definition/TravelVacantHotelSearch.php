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
 * TravelVacantHotelSearch
 *
 * @package RakutenRws
 * @subpackage Api\Definition
 */
class TravelVacantHotelSearch extends AppRakutenApi
{
    protected
        $autoSetIterator = true,
        $arrayName = 'hotels',
        $entityName = 'hotel',
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2013-10-24' => '20131024',
        );

    public function getService()
    {
        return 'Travel';
    }

    public function getOperation()
    {
        return 'VacantHotelSearch';
    }
}
