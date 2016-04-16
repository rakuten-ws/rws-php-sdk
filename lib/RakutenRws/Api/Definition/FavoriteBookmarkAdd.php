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
 * FavoriteBookmarkAdd
 *
 * @package RakutenRws
 * @subpackage Api\Definition
 */
class FavoriteBookmarkAdd extends AppRakutenApi
{
    protected
        $versionMap = array(
            '2012-06-27' => '20120627'
        );

    public function getService()
    {
        return 'FavoriteBookmark';
    }

    public function getOperation()
    {
        return 'Add';
    }

    public function getMethod()
    {
        return 'POST';
    }
}
