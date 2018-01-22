<?php

namespace Omnipay\BeGateway;

use GuzzleHttp\Client as HttpClient;
use Omnipay\BeGateway\Message\EripRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class Gateway
 *
 * @package Omnipay\BeGateway
 */
class Gateway extends AbstractGateway
{
    /**
     * The name of the gateway.
     */
    const NAME = 'BeGateway';

    /**
     * BePaid base url for requests.
     *
     * @var string
     */
    protected $apiBaseUrl = 'https://api.bepaid.by';

    /**
     * Gets the name of the gateway.
     *
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * Initializes this gateway with default parameters.
     *
     * @param array $params
     * @return AbstractGateway
     */
    public function initialize(array $params = []): AbstractGateway
    {
        if (!empty($params)) {
            $this->httpClient = $this->httpClient ?: $this->getDefaultHttpClient($params);
        }

        return $this;
    }

    /**
     * Gets the Erip request.
     *
     * @param array $params
     * @return RequestInterface
     */
    public function purchase(array $params = []): RequestInterface
    {
        return $this->createRequest(EripRequest::class, $params);
    }

    /**
     * Gets the global default HTTP client.
     *
     * @param array $params
     * @return HttpClient
     */
    protected function getDefaultHttpClient(array $params): HttpClient
    {
        return new HttpClient([
            'timeout' => 30,
            'base_uri' => $this->apiBaseUrl,
            'auth' => [
                $params['shop_id'],
                $params['shop_key'],
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }
}
