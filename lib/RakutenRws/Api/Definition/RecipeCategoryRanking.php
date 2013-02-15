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
 * RecipeCategoryList
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_RecipeCategoryRanking extends RakutenRws_Api_AppRakutenApi
{
    protected
        $isRequiredAccessToken = false,
        $versionMap = array(
            '2012-11-21' => '20121121'
        );

    public function getService()
    {
        return 'Recipe';
    }

    public function getOperation()
    {
        return 'CategoryRanking';
    }

    public function execute($parameter)
    {
        $appresponse = parent::execute($parameter);

        if ($appresponse->isOk()) {
            $data = $appresponse->getData();
            if (!isset($data['result'])) {
                throw new RakutenRws_Exception();
            }

            $appresponse->setIterator($data['result']);
        }

        return $appresponse;
    }
}
