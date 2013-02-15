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
 * API for api.rakuten.co.jp
 *
 * @package RakutenRws
 * @subpackage Api
 */
abstract class RakutenRws_Api_RwsApi extends RakutenRws_Api_Base
{
    const BASE_URL = 'http://api.rakuten.co.jp/rws';

    protected
        $version    = null,
        $versionMap = array(),
        $client     = null;

    protected function genUrl($parameter)
    {
        $url  = self::BASE_URL;
        $url .= '/'.$this->versionMap[$this->version];
        $url .= '/json';

        $parameter['version']     = $this->getVersion();
        $parameter['operation']   = $this->getOperationName();
        $parameter['developerId'] = $this->client->getApplicationId();

        if ($this->client->getApplicationId()) {
            $parameter['affiliateId'] = $this->client->getAffiliateId();
        }

        unset($parameter['callBack']);

        return $url.'?'.http_build_query($parameter);
    }

    /**
     *
     * @throws RakutenRws_Exception
     */
    public function execute($parameter)
    {
        $alias = $this->resolveAlias($parameter);
        if ($alias !== false) {

            return $alias;
        }

        $client = $this->client->getHttpClient();
        $response = $client->get($this->genUrl($parameter));

        $rwsresponse = new RakutenRws_ApiResponse_RwsResponse($this->getOperationName(), $response);

        if ($this->autoSetIterator && $rwsresponse->isOk()) {
            $data = $rwsresponse->getData();
            if (!isset($data['Body'][$this->getOperationName()]['Items']['Item'])) {
                throw new RakutenRws_Exception();
            }

            $rwsresponse->setIterator($data['Body'][$this->getOperationName()]['Items']['Item']);
        }

        return $rwsresponse;
    }
}
