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
 * KoboGenreSearch
 *
 * @package RakutenRws
 * @subpackage Api\Definition
 */
class KoboGenreSearch extends AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2013-10-10' => '20131010'
        );

    public function getService()
    {
        return 'Kobo';
    }

    public function getOperation()
    {
        return 'GenreSearch';
    }
}
