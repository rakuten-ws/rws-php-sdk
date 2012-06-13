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
 * ItemSearch
 *
 * @package RakutenRws
 * @subpackage Api_Definition
 */
class RakutenRws_Api_Definition_ItemSearch extends RakutenRws_Api_RwsApi
{
    protected
        $versionMap = array(
            '2010-09-15' => '3.0',
            '2010-06-30' => '3.0',
            '2009-04-15' => '3.0',
            '2009-02-03' => '2.0',
            '2008-09-01' => '1.12',
            '2007-10-25' => '1.11',
            '2007-04-11' => '1.7'
        ),
        $autoSetIterator = true;
}
