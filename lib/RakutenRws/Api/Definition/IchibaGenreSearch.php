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
 * IchibaGenreSearch
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_IchibaGenreSearch extends RakutenRws_Api_AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
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
