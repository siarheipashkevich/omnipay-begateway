<?php

namespace Omnipay\BeGateway;

use Omnipay\Common\Helper;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client as HttpClient;
use Omnipay\Common\GatewayInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class AbstractGateway
 *
 * @package Omnipay\BeGateway
 */
abstract class AbstractGateway implements GatewayInterface
{
    /**
     * The name of the gateway.
     */
    const NAME = 'BeGateway';

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var HttpRequest
     */
    protected $httpRequest;

    /**
     * Gateway constructor.
     *
     * @param ClientInterface|null $httpClient
     * @param HttpRequest|null $httpRequest
     */
    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        $this->httpRequest = $httpRequest ?: $this->getDefaultHttpRequest();
    }

    /**
     * Gets the short name of the gateway.
     *
     * @return string
     */
    public function getShortName(): string
    {
        return Helper::getGatewayShortName(get_class($this));
    }

    /**
     * Gets the default parameters.
     *
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return [];
    }

    /**
     * Gets the parameters.
     *
     * @return array
     */
    public function getParameters(): array
    {
        return [];
    }

    /**
     * Creates and initialize a request object.
     *
     * @param string $class
     * @param array $parameters
     * @return mixed
     */
    protected function createRequest(string $class, array $parameters)
    {
        $obj = new $class($this->httpClient, $this->httpRequest);

        return $obj->initialize(array_replace($this->getParameters(), $parameters));
    }

    /**
     * Gets the global default HTTP request.
     *
     * @return HttpRequest
     */
    protected function getDefaultHttpRequest(): HttpRequest
    {
        return HttpRequest::createFromGlobals();
    }
}
