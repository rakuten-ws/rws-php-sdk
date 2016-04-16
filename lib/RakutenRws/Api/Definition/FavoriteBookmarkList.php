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

use RakutenRws\Exception;
use RakutenRws\Api\AppRakutenApi;

/**
 * FavoriteBookmarkList
 *
 * @package RakutenRws
 * @subpackage Api\Definition
 */
class FavoriteBookmarkList extends AppRakutenApi
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
        return 'List';
    }

    public function execute($parameter)
    {
        $response = parent::execute($parameter);

        if ($response->isOk()) {
            $data = $response->getData();
            if (!isset($data['items'])) {
                throw new Exception();
            }

            $items = array();
            foreach ($data['items'] as $item) {
                $items[] = $item['item'];
            }

            $response->setIterator($items);
        }

        return $response;
    }
}
