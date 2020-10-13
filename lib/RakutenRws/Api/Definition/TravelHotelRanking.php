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
 * TravelHotelRanking
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_TravelHotelRanking extends RakutenRws_Api_AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2017-04-26' => '20170426',
            '2013-10-24' => '20131024',
        );

    public function getService()
    {
        return 'Travel';
    }

    public function getOperation()
    {
        return 'HotelRanking';
    }
}
