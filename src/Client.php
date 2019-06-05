<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

namespace Rakuten\WebService;

use LogicException;
use Rakuten\WebService\Api\AppRakutenApi;
use Rakuten\WebService\HttpClient\BasicHttpClient;
use Rakuten\WebService\HttpClient\CurlHttpClient;
use Rakuten\WebService\HttpClient\PearHttpClient;

/**
 * Rakuten Web Service Client
 *
 * @package Rakuten\WebService
 */
class Client
{
    const VERSION = '2.0.0-dev';

    /**
     * @var string
     */
    protected $developerId = null;

    /**
     * @var string
     */
    protected $secret = null;

    /**
     * @var string
     */
    protected $accessToken = null;

    /**
     * @var string
     */
    protected $accessTokenInfo = null;

    /**
     * @var string
     */
    protected $redirectUrl = null;

    /**
     * @var HttpClient
     */
    protected $httpClient = null;

    /**
     * @var string
     */
    protected $affiliateId = null;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * Constructor.
     *
     * @param HttpClient $httpClient HTTP Client instance
     * @throws Exception
     *
     * option parameter
     *   - keys
     */
    public function __construct(HttpClient $httpClient = null, $options = array())
    {
        if (!extension_loaded('openssl')) {
            // @codeCoverageIgnoreStart
            throw new Exception('openssl extension is not loaded.');
            // @codeCoverageIgnoreEnd
        }

        if ($httpClient === null) {

            // @codeCoverageIgnoreStart
            if (function_exists('curl_init')) {
                $httpClient = new CurlHttpClient();
            } else if (version_compare(PHP_VERSION, '5.2.10') >= 0) {
                $httpClient = new BasicHttpClient();
            } else {
                $httpClient = new PearHttpClient();
            }
            // @codeCoverageIgnoreEnd
        }

        $this->httpClient = $httpClient;
        $this->options = $options;
    }


    /**
     * Sets the DeveloperID
     *
     * @param string $developerId The DeveloperID
     */
    public function setApplicationId($developerId)
    {
        $this->developerId = $developerId;
    }

    /**
     * Gets DeveloperID
     *
     * @return string|null The DeveloperID
     */
    public function getApplicationId()
    {
        return $this->developerId;
    }

    /**
     * Sets the AffiliateID
     *
     * @param string $affiliateId The AffiliateID
     */
    public function setAffiliateId($affiliateId)
    {
        $this->affiliateId = $affiliateId;
    }

    /**
     * Gets AffilateID
     *
     * @return string|null The AffiliateID
     */
    public function getAffiliateId()
    {
        return $this->affiliateId;
    }

    /**
     * Sets Application Secret
     *
     * @param string $secret The Application Secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * Sets Redirect Url
     *
     * @param string $redirectUrl The Redirect URL
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Gets OAuth2 Authorize URL
     *
     * @param string $scope The scopes that is separated by ','
     * @return string The Authorize URL
     */
    public function getAuthorizeUrl($scope)
    {
        $url = 'https://app.rakuten.co.jp/services/authorize';
        $parameter = array();
        $parameter = array(
            'response_type' => 'code',
            'client_id'     => $this->developerId,
            'redirect_uri'  => $this->redirectUrl,
            'scope'         => $scope
        );

        return $url.'?'.http_build_query($parameter);
    }

    /**
     * Gets OAuth2 Access Token URL
     *
     * @return string The OAuth2 Access Token URL
     */
    public function getAccessTokenUrl()
    {
        return 'https://app.rakuten.co.jp/services/token';
    }

    /**
     * Fetches OAuth2 AccessToken from Code
     *
     * @param string $code The Code
     * @return string The Access Token, If response is invalid return null
     * @throws LogicException
     */
    public function fetchAccessTokenFromCode($code = null)
    {
        if ($code === null) {
            if (!isset($_GET['code'])) {
                throw new LogicException("A parameter code is not set.");
            }

            $code = $_GET['code'];
        }

        $url = $this->getAccessTokenUrl();
        $parameter = array(
            'grant_type'    => 'authorization_code',
            'client_id'     => $this->developerId,
            'client_secret' => $this->secret,
            'code'          => $code,
            'redirect_uri'  => $this->redirectUrl
        );

        $response = $this->httpClient->post(
            $url,
            $parameter
        );

        if ($response->getCode() == 200) {
            $this->accessTokenInfo = json_decode($response->getContents(), true);
            if (isset($this->accessTokenInfo['access_token'])) {
                $this->accessToken = $this->accessTokenInfo['access_token'];

                return $this->accessToken;
            }
        }

        return null;
    }

    /**
     * Gets the fetched AccessToken
     *
     * @return string|null The AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Gets Http Client instance
     *
     * @return HttpClient The Http Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Sets the proxy to use connect rakuten service
     *
     * @param string $proxy The proxy
     */
    public function setProxy($proxy)
    {
        $this->httpClient->setProxy($proxy);
    }

    /**
     * Executes API
     *
     * @param string $operation The operation name
     * @param array  $parameter The request parameter
     * @param string $version   The API version
     * @throws LogicException
     * @throws Exception
     */
    public function execute($operation, $parameter = array(), $version = null)
    {
        // remove '/' from operation
        $operation = preg_replace('/\//', '', $operation);

        $className = 'Rakuten\\WebService\\Api\\Definition\\'.$operation;
        if (!class_exists($className)) {
            throw new LogicException('Operation is not definied.');
        }

        /** @var AppRakutenApi $api */
        $api = new $className($this, $this->options);
        if ($version !== null) {
            $api->setVersion($version);
        }

        return $api->execute($parameter);
    }
}
