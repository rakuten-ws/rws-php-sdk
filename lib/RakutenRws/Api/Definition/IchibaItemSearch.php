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
 * IchibaItemSearch
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_IchibaItemSearch extends RakutenRws_Api_AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
            '20120723' => '20120723'
        );

    public function getService()
    {
        return 'IchibaItem';
    }

    public function getOperation()
    {
        return 'Search';
    }

    public function execute($parameter)
    {
        $response = parent::execute($parameter);

        if ($response->isOk()) {
            $data = $response->getData();
            if (!isset($data['Items'])) {
                throw new RakutenRws_Exception();
            }

            $items = array();
            foreach ($data['Items'] as $item) {
                $items[] = $item['Item'];
            }

            $response->setIterator($items);
        }

        return $response;
    }
}

