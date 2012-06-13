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
 * VacantHotelSearch
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_VacantHotelSearch extends RakutenRws_Api_RwsApi
{
    protected
        $versionMap = array(
            '2009-10-20' => '3.0',
        );

    public function execute($parameter)
    {
        $rwsresponse = parent::execute($parameter);

        if ($rwsresponse->isOk()) {
            $data = $rwsresponse->getData();
            if (!isset($data['Body']['hotel'])) {
                throw new RakutenRws_Exception();
            }

            $rwsresponse->setIterator($data['Body']['hotel']);
        }

        return $rwsresponse;
    }
}
