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
 * HotelDetailSearch
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_HotelDetailSearch extends RakutenRws_Api_RwsApi
{
    protected
        $versionMap = array(
            '2009-09-09' => '3.0',
            '2009-03-26' => '2.0',
            '2008-11-13' => '1.12',
            '2007-04-11' => '1.7',
        );

    public function execute($parameter)
    {
        $rwsresponse = parent::execute($parameter);

        if ($rwsresponse->isOk()) {
            $data = $rwsresponse->getData();
            if (!isset($data['Body'][$this->getOperationName()]['hotel'])) {
                throw new RakutenRws_Exception();
            }

            $rwsresponse->setIterator($data['Body'][$this->getOperationName()]['hotel']);
        }

        return $rwsresponse;
    }
}
