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
 * FavoriteBookmarkList
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_FavoriteBookmarkList extends RakutenRws_Api_AppRakutenApi
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
                throw new RakutenRws_Exception();
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
