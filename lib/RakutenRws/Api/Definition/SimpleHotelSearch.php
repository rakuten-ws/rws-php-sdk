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
 * SimpleHotelSearch
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_SimpleHotelSearch extends RakutenRws_Api_RwsApi
{
    protected
        $versionMap = array(
            '2009-10-20' => '3.0',
            '2009-09-09' => '3.0',
            '2008-11-13' => '2.0',
            '2007-07-21' => '1.11',
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
